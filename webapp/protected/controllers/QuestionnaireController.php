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
        $this->render('view', array(
            'model' => $model,
        ));
    }
    
    /**
     * Action to save the questionnaire a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionSave($id) {
        $model = $this->loadModel($id);
        $answer=$this->saveQuestionnaireAnswers($model);
        $this->render('view', array(
            'model' => $answer,
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
        $answer->login=Yii::app()->user->name;
        foreach ($model->questions_group as $question_group) {
            foreach ($question_group->questions as $question) {
                $input = $question_group->id . "_" . $question->id;
                if (isset($_POST[$input])) {
                    $answer->addAnswer($question_group->id, $question->id, $_POST[$input]);
                }
            }
        }
        if ($answer->save())
            Yii::app()->user->setFlash('success', "Questionnaire saved with success");
        else {
            Yii::app()->user->setFlash('error', "Questionnaire not saved. A problem occured.");
            Yii::log("pb save answer" . print_r($answer->getErrors()), CLogger::LEVEL_ERROR);
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
        Yii::app()->user->setFlash('warning', '<strong>Warning!</strong> Feature not available at this thime!.');
        /* if (isset($_POST['Questionnaire'])) {
          $model->attributes = $_POST['Questionnaire'];
          if ($model->save())
          $this->redirect(array('view', 'id' => $model->id));
          } */

        $this->render('update', array(
            'model' => $model,
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
