<?php

/**
 * Object question form to add question to a question group
 *  * @property integer $id
 * @author nmalservet
 *
 */
class QuestionnaireQuetsionForm extends CFormModel {

    /**
     * fields to manage add question group
     */
    public $formQuestionId;
    public $formQuestionLabel;
    public $formQuestionLabelFr;
    public $formQuestionType;
    public $formQuestionStyle;

    public function rules() {
        return array(
            array(
                'formQuestionId,formQuestionLabel,formQuestionLabelFr,formQuestionType,formQuestionStyle', 'required',
            ),
        );
    }

    public function attributeLabels() {

        return array(

        );
    }

    /**
     * update questionnaire with fields filled.
     * Add question group if necessary
     */
    public function updateForm() {
        $result = false;
        //check if fields required are filled
        if ($this->validate()) {
            $qg = new QuestionGroup;
            $qg->id = $this->formQuestionGroupId;
            $qg->title = $this->formQuestionGroupTitle;
            $qg->title_fr = $this->formQuestionGroupTitleFr;
            $this->questions_group[] = $qg;
            //delete fields filled to not add specific items to the mongod document
            $this->formQuestionGroupId=null;
            $this->formQuestionGroupTitle=null;
            $this->formQuestionGroupTitleFr=null;
            //unset scenario to pass fields
            $this->save();
            $result = true;
        }
        return $result;
    }

}

?>