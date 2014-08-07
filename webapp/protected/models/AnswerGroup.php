<?php

/**
 * classe embarquée AnswerGroup, définit les objets Question dans les questionnaires
 * @author matthieu
 *
 */
class AnswerGroup extends EMongoEmbeddedDocument {

    public $id;
    public $title;
    public $title_fr;
    public $answers;

    public function behaviors() {
        return array('embeddedArrays' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'answers', // name of property, that will be used as an array
                'arrayDocClassName' => 'AnswerQuestion'  // class name of embedded documents in array
            ),
        );
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array(
                'id',
                'required'
        ));
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Id',
            'title' => 'title',
            'title_fr' => 'titre',
        );
    }

    /**
     * copy attributes of questionGroup recursively to the final state answer-question.
     * @param type $questionnaire
     */
    public function copy($questionGroup) {
        $this->id = $questionGroup->id;
        $this->title = $questionGroup->title;
        $this->title_fr = $questionGroup->title_fr;
        foreach ($questionGroup->questions as $question) {
            $aq = new AnswerQuestion;
            $aq->copy($question);
            $this->answers[]=$aq;
        }
    }
}
