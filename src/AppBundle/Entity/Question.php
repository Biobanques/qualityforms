<?php

namespace AppBundle\Entity;

use Sokil\Mongo\Structure;

/**
 * classe embarquée Question, définit les objets Question dans les questionnaires
 * @author matthieu
 *
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

    public function getId() {
        return $this->id;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getLabel_fr() {
        return $this->label_fr;
    }

    public function getType() {
        return $this->type;
    }

    public function getStyle() {
        return $this->style;
    }

    public function getValues() {
        return $this->values;
    }

    public function getValues_fr() {
        return $this->values_fr;
    }

    public function getHelp() {
        return $this->help;
    }

    public function getPrecomment() {
        return $this->precomment;
    }

    public function getPrecomment_fr() {
        return $this->precomment_fr;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

    public function setLabel_fr($label_fr) {
        $this->label_fr = $label_fr;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setStyle($style) {
        $this->style = $style;
    }

    public function setValues($values) {
        $this->values = $values;
    }

    public function setValues_fr($values_fr) {
        $this->values_fr = $values_fr;
    }

    public function setHelp(type $help) {
        $this->help = $help;
    }

    public function setPrecomment(type $precomment) {
        $this->precomment = $precomment;
    }

    public function setPrecomment_fr(type $precomment_fr) {
        $this->precomment_fr = $precomment_fr;
    }

}