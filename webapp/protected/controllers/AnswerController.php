<?php

class AnswerController extends Controller {
    /**
     *  NB : boostrap theme need this column2 layout
     * 
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

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
            array('allow', 'users' => array('@'),
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
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new EMongoDocumentDataProvider('Answer');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
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
        $model = Answer::model()->findByPk(new MongoID($id));
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

    /*
     * render html the current question.
     */
    /* public function saveQuestion($idquestiongroup,$idquestion) {
      $input=$idquestiongroup . "_" . $idquestion;
      if(isset($_POST[$input]))
      //affichage de l input selon son type
      if ($question->type == "input") {
      $result.="<input type=\"text\" name=\"" . $idquestiongroup . "_" . $idquestion . "\">";
      }
      if ($question->type == "radio") {
      $values = $question->values;
      $arvalue = split(",", $values);
      foreach ($arvalue as $value) {
      $result.="<input type=\"radio\" name=\"" . $idquestiongroup . "_" . $idquestion . "\" value=\"" . $value . "\">" . $value . "</input>";
      }
      }
      if ($question->type == "checkbox") {
      $values = $question->values;
      $arvalue = split(",", $values);
      foreach ($arvalue as $value) {
      $result.="<input type=\"checkbox\" name=\"" . $idquestiongroup . "_" . $question->id . "\" value=\"" . $value . "\">" . $value . "</input>";
      }
      }
      if ($question->type == "text") {
      $result.="<input type=\"textarea\" rows=\"4\" cols=\"50\" name=\"" . $idquestiongroup . "_" . $question->id . "\" ></input>";
      }
      return $result;
      } */
}
