<?php

namespace Biobanques\UserBundle\Tests\Controller;

use Biobanques\UserBundle\Entity\User;
use MongoDate;
use Sokil\Mongo\Collection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuestionnaireControllerTest extends WebTestCase
{
    protected $client;

    public function setUp() {
        self::bootKernel();
        $this->client = static::createClient([], [
                    'HTTP_HOST' => 'qualityform_v2.local',
//        'PHP_AUTH_USER' => 'matth',
//        'PHP_AUTH_PW' => 'guizmo',
        ]);
        $this->client->followRedirects(true);
    }

    public function testIndex() {

        $crawler = $this->client->request('GET', '/questionnaire/index');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertEquals('Questionnaires index', $crawler->filter('h2')->text());
    }

    public function testGetQuestionnaireAction() {
        $columns = [];
        $columns[0]['data'] = '_id';
        $columns[0]['name'] = '';
        $columns[0]['orderable'] = true;
        $columns[0]['search']['regex'] = false;
        $columns[0]['search']['value'] = '';
        $columns[0]['searchable'] = true;

        $columns[1]['data'] = 'name';
        $columns[1]['name'] = '';
        $columns[1]['orderable'] = true;
        $columns[1]['search']['regex'] = true;
        $columns[1]['search']['value'] = '';
        $columns[1]['searchable'] = true;

        $columns[2]['data'] = 'descrription';
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
        $response = $this->client->request('POST', '/questionnaire/getQuestionnaires', $postData);
        $this->assertTrue(
                $this->client->getResponse()->headers->contains(
                        'Content-Type', 'application/json'
                )
        );
    }

    public function testViewAction() {
        $this->initTestQuestionnaire();

        $id = 'testQuestionnaire_id';

        $crawler = $this->client->request('GET', "/questionnaire/$id/view");

        $this->assertRegExp("/View questionnaire testQuestionnaireName/", $crawler->filter('h2')->text());
        $this->deleteTestQuestionnaire();
    }

    public function testUpdateAction() {
        $this->initTestQuestionnaire();
        $id = 'testQuestionnaire_id';
        $crawler = $this->client->request('GET', "/questionnaire/$id/update");
        /*
         * Assert redirect to login if non authenticated
         */
        $this->assertEquals("Login", $crawler->filter('h2')->text());
        /*
         * Relaunch client with authentication
         */
        $this->client = static::createClient([], [
                    'HTTP_HOST' => 'qualityform_v2.local',
                    'PHP_AUTH_USER' => 'matth',
                    'PHP_AUTH_PW' => 'guizmo',
        ]);
        $this->client->followRedirects(true);
        $crawler = $this->client->request('GET', "/questionnaire/$id/update");

        $this->assertRegExp("/Update questionnaire testQuestionnaireName/", $crawler->filter('h2')->text());
        $form = $crawler->selectButton('updateQuestionnaireButton')->form(['Questionnaire[depositoridentification_depositorname]' => 'testContributor']);
        $crawler = $this->client->submit($form);
        $this->assertRegExp("/Update answer testQuestionnaireName/", $crawler->filter('h2')->text());

        $this->assertRegExp("/Questionnaire saved with success/", $crawler->filter('.alert')->text());

        $answer = self::$kernel->getContainer()->get('mongo')->getCollection('answer')->find()->where('questionnaireMongoId', 'testQuestionnaire_id')->findOne();
        $answer->delete();
    }

    public function initTestQuestionnaire() {
        $container = self::$kernel->getContainer();
        /* @var $collection Collection */
        $collection = $container->get('mongo')->getCollection('questionnaire');
        if ($collection->getDocument('testQuestionnaire_id') != null)
            $this->deleteTestQuestionnaire();
        $collection->insert(json_decode(''
                        . '{"_id" : "testQuestionnaire_id", '
                        . '"id" : "testQuestionnaireId",'
                        . '"name" : "testQuestionnaireName",'
                        . '"name_fr" : "testQuestionnaireNameFr",'
                        . '"description" : "Questionnaire de test",'
                        . '"message_start" : "Welcome to the Test Questionnaire",'
                        . '"message_end" : "Thanks for your job","references" : "",'
                        . '"contributors" : "Matthieu PENICAUD",'
                        . '"questions_group" : [{"id" : "depositoridentification",'
                        . '"title" : "Depositor identification","title_fr" : "Identification du déposant",'
                        . '"questions" : [{'
                        . '"id" : "depositorname",'
                        . '"label" : "Depositor name",'
                        . '"label_fr" : "Nom du déposant",'
                        . '"type" : "input",'
                        . '"order" : "1"}]}]}'
                        , true));
        $collection->getDocument('testQuestionnaire_id')->set('last_modified', new MongoDate())->save();
    }

    public function deleteTestQuestionnaire() {
        $container = self::$kernel->getContainer();
        /* @var $collection Collection */
        $collection = $container->get('mongo')->getCollection('questionnaire');
        $collection->getDocument('testQuestionnaire_id')->delete();
    }

}