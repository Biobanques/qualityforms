<?php

namespace Biobanques\UserBundle\Tests\Controller;

use Biobanques\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BackendControllerTest extends WebTestCase
{
    protected $client;

    public function setUp() {
        self::bootKernel();
        $this->client = static::createClient([], [
                    'HTTP_HOST' => 'qualityform_v2.local',
                    'PHP_AUTH_USER' => 'matth',
                    'PHP_AUTH_PW' => 'guizmo',
        ]);
        $this->client->followRedirects(true);
    }

    public function testIndex() {

        $crawler = $this->client->request('GET', '/admin/users/index');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertRegExp('/Logout \(matth\)/', $crawler->filter('.last')->last()->text());
        $this->assertEquals('Users index', $crawler->filter('h2')->text());
    }

    public function testGetUsersAction() {
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
        $response = $this->client->request('POST', '/admin/users/getUsers', $postData);
        $this->assertTrue(
                $this->client->getResponse()->headers->contains(
                        'Content-Type', 'application/json'
                )
        );
    }

    /**
     * Tests of crud actions - Keep this in order (create - view / update - delete)
     */
    public function testCRUD() {
        /*
         * Test Create invalid user
         */
        $crawler = $this->client->request('GET', '/admin/users/create');
        $this->assertRegExp('/Create user/', $crawler->filter('h2')->text());
        $this->assertGreaterThan(0, $crawler->filter('#username')->count());
        $this->assertGreaterThan(0, $crawler->filter('#password')->count());
        $this->assertGreaterThan(0, $crawler->filter('#roleAdminCB')->count());
        $this->assertGreaterThan(0, $crawler->filter('#roleUserCB')->count());
        $collection = $this->client->getContainer()
                ->get('mongo')
                ->getCollection('user');
        $form = $crawler->selectButton('Create')->form([
            'username' => '',
            'password' => $this->client->getContainer()
                    ->get('security.password_encoder')
                    ->encodePassword(
                            new User($collection), ''
                    ),
            'roles' => []
                ]
        );

        $crawler = $this->client->submit($form); //must show errors

        $this->assertRegExp('/Create user/', $crawler->filter('h2')->text());
        $this->assertGreaterThan(0, $crawler->filter('.alert')->count());
        /*
         * Test Create valid user
         */
        $form = $crawler->selectButton('Create')->form([
            'username' => 'testUser',
            'password' => $this->client->getContainer()
                    ->get('security.password_encoder')
                    ->encodePassword(
                            new User($collection), 'testUserPWD'
                    ),
            'roles' => ['ROLE_ADMIN', 'ROLE_USER']
                ]
        );

        $crawler = $this->client->submit($form); //must redirect to view

        /*
         * Test view
         */
        $this->assertRegExp('/View user/', $crawler->filter('h2')->text());
        $this->assertEquals('testUser', $crawler->filter('#username')->attr('value'));

        $user = $collection->find()->where('username', 'testUser')->findOne();
        /*
         * Test Update invalid user
         */
        $crawler = $this->client->request('GET', "/admin/users/$user->_id/update");

        $this->assertRegExp('/Update user/', $crawler->filter('h2')->text());

        $form = $crawler->selectButton('Update')->form([
            'username' => '',
            'password' => $this->client->getContainer()
                    ->get('security.password_encoder')
                    ->encodePassword(
                            new User($collection), ''
                    ),
            'roles' => []
                ]
        );

        $crawler = $this->client->submit($form); //must show errors

        $this->assertRegExp('/Update user/', $crawler->filter('h2')->text());
        $this->assertGreaterThan(0, $crawler->filter('.alert')->count());
        /*
         * Test Update valid user
         */
        $form = $crawler->selectButton('Update')->form([
            'username' => 'testUserNewName',
            'password' => $this->client->getContainer()
                    ->get('security.password_encoder')
                    ->encodePassword(
                            new User($collection), 'testUserPWD'
                    ),
            'roles' => []
                ]
        );
        $crawler = $this->client->submit($form); //must redirect to view

        $this->assertRegExp('/View user/', $crawler->filter('h2')->text());

        /*
         * Test Delete user
         */

        $crawler = $this->client->request('GET', "/admin/users/$user->_id/delete");
        $this->assertRegExp('/Users index/', $crawler->filter('h2')->text());
    }

    public function testViewAction() {

    }

    public function testUpdateAction() {

    }

    public function testDeleteAction() {

    }

}