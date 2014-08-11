<?php

class QuestionnaireController extends Controller {

    /**
     *  NB : boostrap theme need this column2 layout
     * 
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', 'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $answer = null;
        if (isset($_POST['Questionnaire'])) {
            $answer = $this->saveQuestionnaireAnswers($model);
        }
        if ($answer != null)
            $model = $answer;
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * save answers by this questionnaire.
     * for each question group then question save answer
     * //copy the questionnaire into answer
     * //then fill it with answers
     * @param questionnaire
     */
    public function saveQuestionnaireAnswers($model) {
        $answer = new Answer;
        $answer->copy($model);
        $answer->login = Yii::app()->user->name;
        $flagNoInputToSave = true;
        foreach ($answer->answers_group as $answer_group) {
            foreach ($answer_group->answers as $answerQuestion) {
                $input = $answer_group->id . "_" . $answerQuestion->id;
                if (isset($_POST['Questionnaire'][$input])) {
                    $flagNoInputToSave = false;
                    $answerQuestion->setAnswer($_POST['Questionnaire'][$input]);
                }
            }
        }if ($flagNoInputToSave == false) {
            if ($answer->save())
                Yii::app()->user->setFlash('success', "Questionnaire saved with success");
            else {
                Yii::app()->user->setFlash('error', "Questionnaire not saved. A problem occured.");
                Yii::log("pb save answer" . print_r($answer->getErrors()), CLogger::LEVEL_ERROR);
            }
        } else {
            Yii::app()->user->setFlash('error', "Questionnaire not saved. No Input to save.");
            //null result
            $answer = null;
        }

        return $answer;
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewOnePage($id) {
        $this->render('view_onepage', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $form = new QuestionnaireGroupForm;
        Yii::app()->user->setFlash('warning', '<strong>Warning!</strong> Feature not available at this thime!.');
         if (isset($_POST['QuestionnaireGroupForm'])) {
          $form->attributes = $_POST['QuestionnaireGroupForm'];
          if ($model->updateForm($form))
            Yii::app()->user->setFlash('success', "Questionnaire updated with success");
          }else {
             Yii::app()->user->setFlash('error', "Questionnaire not updated. A problem occured.");
        } 

        $this->render('update', array(
            'model' => $model,
            'form' => $form,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new EMongoDocumentDataProvider('Questionnaire');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Sample('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Questionnaire']))
            $model->attributes = $_GET['Questionnaire'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Questionnaire the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Questionnaire::model()->findByPk(new MongoID($id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Questionnaire $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'questionnaire-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
