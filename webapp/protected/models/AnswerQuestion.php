<?php

/**
 * embedded class question-answer, store question id and ansswer filled
 * @author nmalservet
 *
 */
class AnswerQuestion extends EMongoEmbeddedDocument {

    public $id;
    public $label;
    public $label_fr;
    public $type;
    /*
     * css style applied to the label.
     */
    public $style;

    /**
     * values if question type is radio
     */
    public $values;

    /**
     * values if question type is radio and french setted
     */
    public $values_fr;

    /**
     * valeu of the answer
     * @var type 
     */
    public $answer;

    /**
     * columns if type is array
     * @var type 
     */
    //public $columns;

    /**
     * rows if type is array
     * @var type 
     */
    //public $rows;
    
    /**
         *comment on the top of the question
         * @var type 
         */
        public $precomment;
        
            /**
         *comment on the top of the question
         * @var type 
         */
        public $precomment_fr;

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array(
                'label, answer',
                'required'
        ));
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'label' => 'question',
            'answer' => 'answer',
        );
    }

    /**
     * copy attributes of question answer-question.
     * @param type $question
     */
    public function copy($question) {
        $this->id = $question->id;
        $this->label = $question->label;
        $this->label_fr = $question->label_fr;
        $this->type = $question->type;
        $this->style = $question->style;
        $this->values = $question->values;
        $this->values_fr = $question->values_fr;
        $this->precomment = $question->precomment;
        $this->precomment_fr = $question->precomment_fr;
    }

    /**
     * set the value of an answer
     * @param type $val
     */
    public function setAnswer($val) {
            $this->answer = $val;
    }

}
