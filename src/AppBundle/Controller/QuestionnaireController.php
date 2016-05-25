<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Questionnaire;
use AppBundle\Pdf\QuestionnairePDFRenderer;
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
use TCPDF;

class QuestionnaireController extends Controller
{

    /**
     *
     * @return Collection
     */
    public function getCollection() {
        return $this->get('mongo')->getCollection('questionnaire');
    }

    /**
     * @Route("/questionnaire/index", name="indexQuestionnaires")
     */
    public function indexAction(Request $request) {

        $datatable = new stdClass();
        $columns = [];
        $columns[] = ['data' => 'name', 'searchable' => true, 'orderable' => true,];
        $columns[] = ['data' => 'description', 'searchable' => true, 'orderable' => false,];
        $columns[] = ['data' => 'last_modified', 'searchable' => true, 'orderable' => true,];

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
        $datatable->table_id = 'questionnairesTable';
        $datatable->ajaxUrl = '/questionnaire/getQuestionnaires';
        $datatable->crud = ['view' => true, 'update' => true, 'delete' => false];

        return $this->render('questionnaire/index.html.twig', [
                    'object' => 'Questionnaires',
                    'datatable' => $datatable
        ]);
    }

    /**
     * Action used for ajax datatable
     * @Route("/questionnaire/getQuestionnaires",name="getQuestionnaires")
     */
    public function getQuestionnairesAction(Request $request) {
        $query = new DatatableQueries($this->getCollection(), $request->request->getIterator());
        $result = $query->getData();
        return JsonResponse::create($result);
    }

    /**
     *
     * @param Request $request
     * @Route("/questionnaire/{id}/view",name="viewQuestionnaire")
     */
    public function viewAction(Request $request, $id) {
        $questionnaire = $this->getCollection()->getDocument($id);


        return $this->render('/questionnaire/form.html.twig', [

                    'questionnaire' => $questionnaire,
                    'lang' => 'fr',
                    'isAnswered' => false,
                    'action' => 'view',
        ]);
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @Route("/questionnaire/{id}/update",name="updateQuestionnaire")
     */
    public function updateAction(Request $request, $id) {
        /* @var Questionnaire */
        $questionnaire = $this->getCollection()->getDocument($id);
        $post = $request->request->all();
        $answer = null;
        $isAnswered = false;


        if ($post != []) {
            $answer = $this->saveQuestionnaireAnswers($questionnaire, $post);
            if ($answer != null) {
                $questionnaire = $answer;
                $isAnswered = true;
            }
        }
        return $this->render('/questionnaire/form.html.twig', [
                    'questionnaire' => $questionnaire,
                    'lang' => 'fr',
                    'isAnswered' => $isAnswered,
                    'action' => 'update'
        ]);
    }

    public function saveQuestionnaireAnswers($model, $post) {
        $answer = new Answer($this->get('mongo')->getCollection('answer'));
        $answer->last_updated = new MongoDate();
        $answer->copy($model);
        $answer->login = $this->getUser()->getUsername();
        $flagNoInputToSave = true;
        $groupCounter = 0;
        foreach ($answer->getAnswers_group()as $answer_group) {
            $answerCounter = 0;
            foreach ($answer_group->getAnswers() as $answerQuestion) {
                $input = $answer_group->get('id') . "_" . $answerQuestion->get('id');
                if (isset($post['Questionnaire'][$input]) && $post['Questionnaire'][$input] != "") {
                    $flagNoInputToSave = false;
                    $answerQuestion->setAnswer($post['Questionnaire'][$input]);
                }

                //@codeCoverageIgnoreStart
                if ($answerQuestion->get('type') == "array") {
//construct each id input an dget the result to store it
                    $rows = $answerQuestion->rows;
                    $arrows = split(",", $rows);
                    $cols = $answerQuestion->columns;
                    $arcols = split(",", $cols);
                    $answerArray = "";
                    foreach ($arrows as $row) {
                        foreach ($arcols as $col) {
                            $idunique = $idquestiongroup . "_" . $question->id . "_" . $row . "_" . $col;
                            if (isset($post['Questionnaire'][$idunique])) {
                                $answerArray.=$post['Questionnaire'][$idunique] . ",";
                            }
                        }
                    }
                    $answerQuestion->setAnswer($answerArray);
                }
                //@codeCoverageIgnoreEnd

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
            if ($answer->save())
                $this->addFlash('success', 'Questionnaire saved with success');
            else {
                $this->addFlash('error', 'Questionnaire not saved. A problem occured.');
            }
        } else {
            $this->addFlash('error', 'No input to save');
//null result
            $answer = null;
        }

        return $answer;
    }

    /**
     * Export to PDF
     * @Route("/questionnaire/{id}/exportpdf",name="exportPDFQuestionnaire")
     */
    public function actionExportPDF(Request $request, $id) {

        $questionnaire = $this->getCollection()->getDocument($id);
        /* @var TCPDF */
        $pdf = $this->container->get('white_october.tcpdf')->create();
        return QuestionnairePDFRenderer::render($pdf, $questionnaire);
    }

    /**
     * Export to PDF
     * @Route("/questionnaire/{id}/viewonepage",name="viewOnePage")
     */
    public function actionViewOnePage(Request $request, $id) {

        $questionnaire = $this->getCollection()->getDocument($id);
        return $this->render('/questionnaire/formOnePage.html.twig', [
                    'questionnaire' => $questionnaire,
                    'lang' => 'fr',
                    'isAnswered' => false,
                    'action' => 'view'
        ]);
    }

}