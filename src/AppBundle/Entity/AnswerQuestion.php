<?php

namespace AppBundle\Entity;

use Sokil\Mongo\Structure;

/**
 * embedded class question-answer, store question id and ansswer filled
 * @author nmalservet
 *
 */
class AnswerQuestion extends Structure
{
    private $id;
    private $label;
    private $label_fr;
    private $type;
    /*
     * css style applied to the label.
     */
    private $style;
    /**
     * values if question type is radio
     */
    private $values;
    /**
     * values if question type is radio and french setted
     */
    private $values_fr;
    /**
     * valeu of the answer
     * @var type
     */
    private $answer;
    /**
     * comment on the top of the question
     * @var type
     */
    private $precomment;
    /**
     * comment on the top of the question
     * @var type
     */
    private $precomment_fr;

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
     * copy attributes of question answer-question.
     * @param type $question
     */
    public function copy($question) {
        $this->set('id', $question->id);
        $this->set('label', $question->label);
        $this->set('label_fr', $question->label_fr);
        $this->set('type', $question->type);
        $this->set('style', $question->style);
        $this->set('values', $question->values);
        $this->set('values_fr', $question->values_fr);
        $this->set('precomment', $question->precomment);
        $this->set('precomment_fr', $question->precomment_fr);
        $this->setAnswer(null);
    }

    /**
     * set the value of an answer
     * @param type $val
     */
    public function setAnswer($val) {
        $this->set('answer', $val);
    }

}