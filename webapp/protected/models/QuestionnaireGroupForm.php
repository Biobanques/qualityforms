<?php

/**
 * Object questionnaire to store a questionnaire definition
 *  * @property integer $id
 * @author nmalservet
 *
 */
class QuestionnaireGroupForm extends CFormModel {

    /**
     * fields to manage add question group
     */
    public $formQuestionGroupId;
    public $formQuestionGroupTitle;
    public $formQuestionGroupTitleFr;

    public function rules() {
        return array(
            array(
                'formQuestionGroupId,formQuestionGroupTitle,formQuestionGroupTitleFr', 'required',
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