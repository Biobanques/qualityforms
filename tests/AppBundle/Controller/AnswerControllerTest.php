<?php

namespace Biobanques\UserBundle\Tests\Controller;

use Biobanques\UserBundle\Entity\User;
use MongoDate;
use Sokil\Mongo\Collection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnswerControllerTest extends WebTestCase
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

        $crawler = $this->client->request('GET', '/answer/index');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertEquals('Answers index', $crawler->filter('h2')->text());
    }

    public function testGetAnswersAction() {
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

        $columns[2]['data'] = 'description';
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
        $response = $this->client->request('POST', '/answer/getAnswers', $postData);


        $this->assertTrue(
                $this->client->getResponse()->headers->contains(
                        'Content-Type', 'application/json'
                )
        );
    }

    public function testViewAction() {

        $id = $this->initTestQuestionnaire();


        $crawler = $this->client->request('GET', "/answer/$id/view");

        $this->assertRegExp("/View answer testQuestionnaireName/", $crawler->filter('h2')->text());
        $this->deleteTestQuestionnaire($id);
    }

    public function testUpdateAction() {
        $id = $this->initTestQuestionnaire();

        $crawler = $this->client->request('GET', "/answer/$id/update");

        $this->assertRegExp("/Update answer testQuestionnaireName/", $crawler->filter('h2')->text());
        $form = $crawler->selectButton('updateQuestionnaireButton')->form(['Answer[depositoridentification_depositorname]' => 'testContributorUpdated']);
        $crawler = $this->client->submit($form);
        $this->assertRegExp("/Update answer testQuestionnaireName/", $crawler->filter('h2')->text());
        $values = $crawler->selectButton('updateQuestionnaireButton')->form()->getValues();
        $this->assertRegExp("/testContributorUpdated/", $values['Answer[depositoridentification_depositorname]']);
        $this->assertRegExp("/Answer saved with success/", $crawler->filter('.alert')->text());

        $this->deleteTestQuestionnaire($id);
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

        $crawler = $this->client->request('GET', "/questionnaire/testQuestionnaire_id/update");

        $form = $crawler->selectButton('updateQuestionnaireButton')->form(['Questionnaire[depositoridentification_depositorname]' => 'testContributor']);
        $crawler = $this->client->submit($form);
        $answer = self::$kernel->getContainer()->get('mongo')->getCollection('answer')->find()->where('questionnaireMongoId', 'testQuestionnaire_id')->findOne();
        return $answer->get('_id');
    }

    public function deleteTestQuestionnaire($id = null) {
        $container = self::$kernel->getContainer();
        /* @var $collection Collection */
        $qCollection = $container->get('mongo')->getCollection('questionnaire');
        $qCollection->getDocument('testQuestionnaire_id')->delete();
        if ($id) {
            $aCollection = $container->get('mongo')->getCollection('answer');
            $aCollection->getDocument($id)->delete();
        }
    }

}