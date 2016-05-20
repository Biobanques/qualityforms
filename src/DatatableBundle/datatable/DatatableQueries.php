<?php

namespace DatatableBundle\datatable;

use ArrayIterator;
use MongoDate;
use MongoId;
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
    private $collection;
    protected $dateFormat = 'd/m/Y';

    /**
     * @codeCoverageIgnore
     * @var int
     */
    public function getSearch() {
        return $this->search;
    }

    public function setSearch($search) {
        $this->search = $search;
    }

    private $search = ['value' => '', 'regex' => true];
    private $draw = 1;
    /**
     *
     * @var int
     */
    private $start = 0;
    /**
     *
     * @var int
     */
    private $length = 10;
//    /**
//     *
//     * @var boolean
//     */
//    private $useRegex;
//    /**
//     *
//     * @var string
//     */
//    private $searchValue;

    /**
     * @codeCoverageIgnore
     * @var array
     */public function getOrder() {
        return $this->order;
    }

    public function setOrder($order) {
        $this->order = $order;
    }

    private $columns;
    private $order;

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getColumns() {
        return $this->columns;
    }

    /**
     * @codeCoverageIgnore
     * @return Collection
     */
    public function getCollection() {
        return $this->collection;
    }

//    /**
//     * @codeCoverageIgnore
//     * @return boolean
//     */
//    public function getUseRegex() {
//        return $this->useRegex;
//    }
//
//    /**
//     * @codeCoverageIgnore
//     * @return string
//     */
//    public function getSearchValue() {
//        return $this->searchValue;
//    }

    /**
     * @codeCoverageIgnore
     * @return int
     */
    public function getDraw() {
        return $this->draw;
    }

    /**
     * @codeCoverageIgnore
     * @return int
     */
    public function getStart() {
        return $this->start;
    }

    /**
     * @codeCoverageIgnore
     * @return int
     */
    public function getLength() {
        return $this->length;
    }

    public function setColumns($columns) {
        $this->columns = $columns;
    }

//    public function setUseRegex($useRegex) {
//        $this->useRegex = $useRegex;
//    }
//
//    public function setSearchValue($searchValue) {
//        $this->searchValue = $searchValue;
//    }

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

    /**
     * @codeCoverageIgnore
     */
    public function __construct(Collection $collection, ArrayIterator $post) {
        if (!$collection instanceof Collection) {
            throw new Exception("No collection provided, can't process data retrieving");
        } else
            $this->setCollection($collection);

        foreach ($post as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (is_callable(array($this, $method))) {
                call_user_func(array($this, $method), $value);
            }
            //$this->$key = $value;
        }
    }

    /**
     *
     * @return array
     */
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
        //skip code coverage (no doc returned in tests)
        //@codeCoverageIgnoreStart
        foreach ($cursor as $doc) {
            $docData = [];
            foreach ($this->columns as $column) {

                $name = $column['data'];


                if ($doc->$name instanceof MongoId)
                    $docData[$name] = (string) $doc->$name;
                elseif ($doc->$name instanceof MongoDate)
                    $docData[$name] = date($this->dateFormat, $doc->$name->sec);
                else
                    $docData[$name] = $doc->$name;
            }
            $result['data'][] = $docData;
        }
        //@codeCoverageIgnoreEnd

        $result['recordsTotal'] = $this->collection->count();
        $result['recordsFiltered'] = $cursor->count();

        return $result;
    }

    /**
     *
     * @return array
     */
    public function createSortParam() {
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

    public function createSearchParams() {
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

    public function createOrCriteria($fieldName) {
        $searchValue = '';
        if (isset($this->search['value']))
            $searchValue = $this->search['value'];

        if ($searchValue != '') {

            if (isset($this->search['regex']) && $this->search['regex'] == 'false')
                return $this->collection->expression()->where($fieldName, $searchValue);

            elseif (!isset($this->search['regex']) || $this->search['regex'] == 'true') {
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

    /**
     * Set format for mongoDate display, with php date() function
     *
     * @param string $format
     */
    public function setDateFormat($format) {
        $this->dateFormat = $format;
    }

}