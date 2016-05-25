<?php

namespace AppBundle\Entity;

use Sokil\Mongo\Structure;

/**
 * classe embarquée Question, définit les objets Question dans les questionnaires
 * @author mpenicaud
 * @codeCoverageIgnore
 */
class Question extends Structure
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
     * help text to add meta information around the question, displayed as an help button
     * @var type
     */
    private $help;
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
                'id',
                'required'
        ));
    }

}