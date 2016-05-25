<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Answer;
use DatatableBundle\datatable\DatatableQueries;
use MongoDate;
use MongoId;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sokil\Mongo\Collection;
use Sokil\Mongo\Document;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_USER')")
 */
class AnswerController extends Controller
{

    /**
     *
     * @return Collection
     */
    public function getCollection() {
        return $this->get('mongo')->getCollection('answer');
    }

    /**
     * @Route("/answer/index", name="indexAnswers")
     */
    public function indexAction(Request $request) {

        $datatable = new stdClass();
        $columns = [];
        $columns[] = ['data' => 'name', 'searchable' => true, 'orderable' => true,];
        $columns[] = ['data' => 'description', 'searchable' => true, 'orderable' => false,];
        $columns[] = ['data' => 'last_updated', 'searchable' => true, 'orderable' => true,];


        $columns[] = [
            //  "className" => 'glyphicon glyphicon-edit ',
            "orderable" => false,
            'title' => 'Manage',
            "data" => '_id',
            "defaultContent" => ''
        ];


        $datatable->columns = $columns;
        /*
         * true or false, in string
         */
        $datatable->useRegex = 'true';
        $datatable->table_id = 'answersTable';
        $datatable->ajaxUrl = '/answer/getAnswers';
        $datatable->crud = ['view' => true, 'update' => true, 'delete' => false];

        return $this->render('questionnaire/index.html.twig', [
                    'object' => 'Answers',
                    'datatable' => $datatable
        ]);
    }

    /**
     * Action used for ajax datatable
     * @Route("/answer/getAnswers",name="getAnswers")
     */
    public function getAnswersAction(Request $request) {
        $query = new DatatableQueries($this->getCollection(), $request->request->getIterator());
        $query->setDateFormat('d/m/Y H\hi');
        $result = $query->getData();

        return JsonResponse::create($result);
    }

    /**
     *
     * @param Request $request
     * @Route("/answer/{id}/view",name="viewAnswer")
     */
    public function viewAction(Request $request, $id) {
        $answer = $this->getCollection()->find()->byId($id)->asObject()->findOne();


        return $this->render('/questionnaire/form.html.twig', [

                    'questionnaire' => $answer,
                    'lang' => 'fr',
                    'isAnswered' => true,
                    'action' => 'view'
        ]);
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @Route("/answer/{id}/update",name="updateAnswer")
     */
    public function updateAction(Request $request, $id) {
        $questionnaire = $this->getCollection()->find()->byId($id)->findOne();
        $post = $request->request->all();
        $answer = null;
        $isAnswered = true;
        if ($request->request->all() != []) {
            $answer = $this->saveAnswerAnswers($questionnaire, $post);
        }
        if ($answer != null) {
            $questionnaire = $answer;
            $isAnswered = true;
        }
        return $this->render('/questionnaire/form.html.twig', [

                    'questionnaire' => $questionnaire,
                    'lang' => 'fr',
                    'isAnswered' => $isAnswered,
                    'action' => 'update'
        ]);
    }

    public function saveAnswerAnswers($answer, $post) {

        $flagNoInputToSave = true;
        $groupCounter = 0;
        foreach ($answer->getAnswers_group()as $answer_group) {
            $answerCounter = 0;
            foreach ($answer_group->getAnswers() as $answerQuestion) {
                $input = $answer_group->get('id') . "_" . $answerQuestion->get('id');
                if (isset($post['Answer'][$input])) {
                    $flagNoInputToSave = false;
                    $answerQuestion->setAnswer($post['Answer'][$input]);
                }
//if array, specific save action
                if ($answerQuestion->type == "array") {
//construct each id input an dget the result to store it
                    $rows = $answerQuestion->rows;
                    $arrows = split(",", $rows);
                    $cols = $answerQuestion->columns;
                    $arcols = split(",", $cols);
                    $answerArray = "";
                    foreach ($arrows as $row) {
                        foreach ($arcols as $col) {
                            $idunique = $idquestiongroup . "_" . $question->id . "_" . $row . "_" . $col;
                            if (isset($post['Answer'][$idunique])) {
                                $answerArray.=$post['Answer'][$idunique] . ",";
                            }
                        }
                    }
                    $answerQuestion->setAnswer($answerArray);
                }

                $group = $answer_group->get('answers');
                $group[$answerCounter] = $answerQuestion->toArray();
                $answer_group->set('answers', $group);
                $answerCounter++;
            }
            $groups = $answer->get('answers_group');
            $groups[$groupCounter] = $answer_group->toArray();
            $answer->set('answers_group', $groups);
            $groupCounter++;
        }
        if ($flagNoInputToSave == false) {
            $answer->set('last_updated', new MongoDate());
            if ($answer->save())
                $this->addFlash('success', 'Answer saved with success');

            else {
                $this->addFlash('error', 'Answer not saved. A problem occured.');
            }
        } else {
            $this->addFlash('error', 'No input to save');

            $answer = null;
        }

        return $answer;
    }

}