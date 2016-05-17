<?php

use DatatableBundle\datatable\DatatableQueries;
use Sokil\Mongo\Expression;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DatatableQueriesTest extends WebTestCase
{
    private $container;

    public function setUp() {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
    }

    /**
     *
     * @return DatatableQueries
     */
    public function getInstance() {
        //   $client = static::createClient();
        $collection = $this->container->get('mongo')->getCollection('testCollection');

        $columns = [];
        $columns[0]['data'] = '_id';
        $columns[0]['name'] = '';
        $columns[0]['orderable'] = true;
        $columns[0]['search']['regex'] = false;
        $columns[0]['search']['value'] = '';
        $columns[0]['searchable'] = true;

        $columns[1]['data'] = 'nameTest';
        $columns[1]['name'] = '';
        $columns[1]['orderable'] = true;
        $columns[1]['search']['regex'] = true;
        $columns[1]['search']['value'] = '';
        $columns[1]['searchable'] = true;

        $columns[2]['data'] = 'passwordTest';
        $columns[2]['name'] = 'ptname';
        $columns[2]['orderable'] = false;
        $columns[2]['search']['regex'] = false;
        $columns[2]['search']['value'] = '';
        $columns[2]['searchable'] = false;

        $order = [];
        $order[0]['column'] = 0;
        $order[0]['dir'] = 'asc';
        $order[1]['column'] = 1;
        $order[1]['dir'] = 'desc';

        $search = [];
        $search['value'] = 'test';
        $search['regex'] = true;

        $postData = [];
        $postData['columns'] = $columns;
        $postData['order'] = $order;
        $postData['draw'] = 1;
        $postData['start'] = 0;
        $postData['length'] = 10;
        $postData['search'] = $search;

        $request = new Request([], $postData);
        $post = $request->request->getIterator();

        return new DatatableQueries($collection, $post);
    }

    public function testGetData() {
        $datatable = $this->getInstance();
        $this->assertTrue(is_array($datatable->getData()));
        $this->assertTrue(isset($datatable->getData()['recordsTotal']));
        $this->assertTrue(isset($datatable->getData()['recordsFiltered']));
        $this->assertTrue(isset($datatable->getData()['data']));
    }

    public function testCreateSortParam() {
        $datatable = $this->getInstance();
        $datatable->setSearch(['value' => 'test', 'regex' => '0']);
        $this->assertEquals(['_id' => 1, 'nameTest' => -1], $datatable->createSortParam());
    }

    public function testCreateSearchParams() {
        $datatable = $this->getInstance();
        $this->assertTrue(is_array($datatable->createSearchParams()));
    }

    public function testCreateOrCriteria() {
        $datatable = $this->getInstance();
        $datatable->setSearch([]);
        $this->assertNull($datatable->CreateOrCriteria('nameTest'));
        $datatable->setSearch(['value' => '', 'regex' => 'false']);
        $this->assertNull($datatable->CreateOrCriteria('nameTest'));
        $datatable->setSearch(['value' => 'test', 'regex' => 'null']);
        $this->assertNull($datatable->CreateOrCriteria('nameTest'));
        $datatable->setSearch(['value' => 'test']);
        $this->assertTrue(
                $datatable->CreateOrCriteria('nameTest') instanceof Expression);
        $datatable->setSearch(['value' => '', 'regex' => 'true']);
        $this->assertNull($datatable->CreateOrCriteria('nameTest'));
        $datatable->setSearch(['value' => 'test', 'regex' => 'false']);
        $this->assertTrue(
                $datatable->CreateOrCriteria('nameTest') instanceof Expression);
        $datatable->setSearch(['value' => 'test', 'regex' => 'true']);
        $this->assertTrue(
                $datatable->CreateOrCriteria('nameTest') instanceof Expression);
    }

}