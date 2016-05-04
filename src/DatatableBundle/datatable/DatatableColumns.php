<?php

namespace DatatableBundle\datatable;

use ArrayIterator;
use Sokil\Mongo\Collection;
use Symfony\Component\Config\Definition\Exception\Exception;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DatatableColumns
{
    /**
     *
     * @var Collection
     */
    public $data;
    /**
     *
     * @var int
     */
    public $name;
    /**
     *
     * @var boolean
     */
    public $searchable = true;
    /**
     *
     * @var int
     */
    public $orderable = true;

    public function getData() {
        return $this->data;
    }

    public function getName() {
        return $this->name;
    }

    public function getSearchable() {
        return $this->searchable;
    }

    public function getOrderable() {
        return $this->orderable;
    }

    public function setData(Collection $data) {
        $this->data = $data;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setSearchable($searchable) {
        $this->searchable = $searchable;
    }

    public function setOrderable($orderable) {
        $this->orderable = $orderable;
    }

}