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
    public $name_fr;
    public $description;
    public $message_start;
    public $message_end;
    public $questions_group;
    /*
     * date last modified.
     */
    public $last_modified;

    /**
     * contributors are people working on thi squetsionnaire
     */
    public $contributors;

    /**
     * fields to manage add question 
     */
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
    public function renderHTML($lang) {
        $result = "";
        foreach ($this->questions_group as $question_group) {
            if ($question_group->parent_group == "") {
                $result.=QuestionnaireHTMLRenderer::renderQuestionGroupHTML($this, $question_group, $lang, false);
                $result.= "<br><div style=\”clear:both;\"></div>";
            }
        }
        $result.=$this->renderContributors();
        return $result;
    }

    public function renderTabbedGroup($lang) {
        return QuestionnaireHTMLRenderer::renderTabbedGroup($this, $lang, false);
    }

    /**
     * update questionnaire with fields filled.
     * Add question group if necessary
     */
    public function updateForm($questionnaireGroupForm) {
        $result = false;
        //check if fields required are filled
        if ($questionnaireGroupForm->validate()) {
            $qg = new QuestionGroup;
            $qg->id = $questionnaireGroupForm->formQuestionGroupId;
            $qg->title = $questionnaireGroupForm->formQuestionGroupTitle;
            $qg->title_fr = $questionnaireGroupForm->formQuestionGroupTitleFr;
            $this->questions_group[] = $qg;
            $this->save();
            $result = true;
        }
        return $result;
    }

    /**
     * render contributors
     * used in plain page and tab page
     * @return string
     */
    public function renderContributors() {
        return QuestionnaireHTMLRenderer::renderContributors($this->contributors);
    }

}

?>