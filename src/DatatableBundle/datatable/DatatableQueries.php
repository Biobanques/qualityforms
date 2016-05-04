<?php

namespace DatatableBundle\datatable;

use ArrayIterator;
use MongoRegex;
use Sokil\Mongo\Collection;
use Symfony\Component\Config\Definition\Exception\Exception;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DatatableQueries
{
    const ACCENT_STRINGS = 'ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËẼÌÍÎÏĨÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëẽìíîïĩðñòóôõöøùúûüýÿ';
    const NO_ACCENT_STRINGS = 'SOZsozYYuAAAAAAACEEEEEIIIIIDNOOOOOOUUUUYsaaaaaaaceeeeeiiiiionoooooouuuuyy';
    /**
     *
     * @var Collection
     */
    public $collection;
    /**
     *
     * @var int
     */
    public $draw;
    /**
     *
     * @var int
     */
    public $start = 0;
    /**
     *
     * @var int
     */
    public $length;
    /**
     *
     * @var boolean
     */
    public $useRegex;
    /**
     *
     * @var string
     */
    public $searchValue;
    /**
     *
     * @var array
     */
    public $columns;

    public function getColumns() {
        return $this->columns;
    }

    public function getCollection() {
        return $this->collection;
    }

    public function getUseRegex() {
        return $this->useRegex;
    }

    public function getSearchValue() {
        return $this->searchValue;
    }

    public function getDraw() {
        return $this->draw;
    }

    public function getStart() {
        return $this->start;
    }

    public function getLength() {
        return $this->length;
    }

    public function setColumns($columns) {
        $this->columns = $columns;
    }

    public function setUseRegex($useRegex) {
        $this->useRegex = $useRegex;
    }

    public function setSearchValue($searchValue) {
        $this->searchValue = $searchValue;
    }

    public function setCollection(Collection $collection) {
        $this->collection = $collection;
    }

    public function setDraw($draw) {
        $this->draw = $draw;
    }

    public function setStart($start) {
        $this->start = $start;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function __construct(Collection $collection, ArrayIterator $post) {
        if (!$collection instanceof Collection) {
            throw new Exception("No collection provided, can't process data retrieving");
        } else
            $this->setCollection($collection);

        foreach ($post as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getData() {

        $result = [];
        $result['data'] = [];
        /**
         * Construct sort param
         */
        // $searchable =
        $cursor = $this->collection->find();

        $searchParams = $this->createSearchParams();
        if (!empty($searchParams)) {

            $cursor->whereOr($searchParams);
        }

        $cursor->skip($this->start);
        if ($this->length != -1)
            $cursor->limit($this->length);
        $sortParams = $this->createSortParam();
        if (!empty($sortParams))
            $cursor->sort($sortParams);
        ;
        foreach ($cursor as $doc) {
            $docData = [];
            foreach ($this->columns as $column) {

                $name = $column['data'];
                if ($name == '_id')
                    $docData[$name] = (string) $doc->$name;
                else
                    $docData[$name] = $doc->$name;
            }
            $result['data'][] = $docData;
        }
        $result['recordsTotal'] = $this->collection->count();
        $result['recordsFiltered'] = $cursor->count();

        return $result;
    }

    protected function createSortParam() {
        $sortParams = [];
        foreach ($this->order as $orderParam) {
            switch ($orderParam['dir']) {
                case 'asc':
                    $dir = 1;
                    break;
                case 'desc': $dir = -1;
                    break;
            }
            $sortParams[$this->columns[$orderParam['column']]['data']] = $dir;
        }
        return $sortParams;
    }

    protected function createSearchParams() {
        $searchParams = [];
        foreach ($this->columns as $column) {
            if ($column['searchable'] == 'true') {
                $newCriteria = $this->createOrCriteria($column['data']);
                if ($newCriteria != null)
                    $searchParams[] = $newCriteria;
            }
        }
        return $searchParams;
    }

    protected function createOrCriteria($fieldName) {
        $searchValue = $this->search['value'];

        if ($searchValue != '') {
            if ($this->search['regex'] == 'false')
                return $this->collection->expression()->where($fieldName, $searchValue);

            elseif ($this->search['regex'] == 'true') {
                $searchValue = str_replace(' ', '|', $searchValue);
                $searchValue = str_replace(',|', '|', $searchValue);
                $searchValue = str_replace(',', '|', $searchValue);
                $searchValue = $this->accentToRegex($searchValue);
                return $this->collection->expression()->where($fieldName, new MongoRegex('/' . $searchValue . '/i'));
            } else {
                return;
            }
        } else
            return;
    }

    /**

     * Returns a string with accent to REGEX expression to find any combinations

     * in accent insentive way

     *

     * @param string $text The text.

     * @return string The REGEX text.

     */
    static public
            function accentToRegex($text) {

        $from = str_split(utf8_decode(self::ACCENT_STRINGS));

        $to = str_split(strtolower(self::NO_ACCENT_STRINGS));

        $text = utf8_decode($text);

        $regex = array();

        foreach ($to as $key => $value) {

            if (isset($regex[$value])) {

                $regex[$value] .= $from[$key];
            } else {

                $regex[$value] = $value;
            }
        }

        foreach ($regex as $rg_key => $rg) {

            $text = preg_replace("/[$rg]/", "_{$rg_key}_", $text);
        }

        foreach ($regex as $rg_key => $rg) {

            $text = preg_replace("/_{$rg_key}_/", "[$rg]", $text);
        }

        return utf8_encode($text);
    }

}