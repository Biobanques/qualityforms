<?php

/**
 * Object questionnaire to store a questionnaire definition
 *  * @property integer $id
 * @author nmalservet
 *
 */
class Questionnaire extends EMongoDocument {

    /**
     * champs classiques d echantillons
     */
    public $id;
    public $name;
    public $description;
    public $message_start;
    public $message_end;
    public $questions_group;

// This has to be defined in every model, this is same as with standard Yii ActiveRecord
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

// This method is required!
    public function getCollectionName() {
        return 'questionnaire';
    }

    public function behaviors() {
        return array('embeddedArrays' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'questions_group', // name of property, that will be used as an array
                'arrayDocClassName' => 'QuestionGroup'  // class name of embedded documents in array
            ),
        );
    }

    public function rules() {
        return array(
            array(
                'id',
                'required'
            ),
            array(
                'id,questions_group',
                'safe',
                'on' => 'search'
            )
        );
    }

    public function attributeLabels() {

        return array(
            'id' => 'id',
        );
    }

    public function attributeExportedLabels() {

        return array(
            'id' => 'id',
            'questions_group' => 'Questions Group',
        );
    }

    public function search($caseSensitive = false) {
        $criteria = new EMongoCriteria ();
        if (isset($this->id) && !empty($this->id)) {
            $criteria->id = "" . $this->id . "";
        }

        Yii::app()->session['criteria'] = $criteria;
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    /**
     * render in html the questionnaire
     */
    public function renderHTML() {
        $result = "";
        foreach ($this->questions_group as $question_group) {
            $result.=$this->renderQuestionGroupHTML($question_group);
            $result.= "<br><div style=\”clear:both;\"></div>";
        }
        return $result;
    }
    /**
     * render an array of association key/question group to display as tab
     */
    public function renderArrayTabGroup() {
        $result = array();
        foreach ($this->questions_group as $question_group) {
            $result[$question_group->title]=$this->renderQuestionGroupHTML($question_group);
        }
        return $result;
    }
    
    public function renderQuestionGroupHTML($question_group){
        $result = "";
        $result.="<div class=\"question_group\"><i>" . $question_group->title . "</i> / " . $question_group->title_fr . "</div>";
        foreach ($question_group->questions as $question) {
            $result.=$this->renderQuestionHTML($question_group->id, $question);
        }
        $result.= "<br><div style=\”clear:both;\"></div>";
        return $result;
    }
    
    /*
         * render html the current question.
         */
        public function renderQuestionHTML($idquestiongroup,$question) {
            $result="";
                $result.="<div  style=\"" . $question->style . "\">";
                $result.="<div class=\"question-label\" ><i>" . $question->label . "</i><br>" . $question->label_fr . "</div>";
                // $result.="</div>";
                $result.="<div class=\"question-input\">";
                //affichage de l input selon son type
                if ($question->type == "input") {
                    $result.="<input type=\"text\" name=\"" . $idquestiongroup . "_" . $question->id . "\">";
                }
                if ($question->type == "radio") {
                    $values = $question->values;
                    $arvalue = split(",", $values);
                    foreach ($arvalue as $value) {
                        $result.="<input type=\"radio\" name=\"" . $idquestiongroup . "_" . $question->id . "\" value=\"" . $value . "\">" . $value . "</input>";
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
                $result.="</div>";
                $result.="</div>";
                return $result;
                }
    

}

?>