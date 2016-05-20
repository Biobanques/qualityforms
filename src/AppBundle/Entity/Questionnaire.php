<?php

namespace AppBundle\Entity;

use AppBundle\Renderer\QuestionnaireHTMLRenderer;
use Sokil\Mongo\Document;
use Sokil\Mongo\Exception;
use Sokil\Mongo\Structure;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @codeCoverageIgnore
 */
class Questionnaire extends Document
{
    /**
     * champs classiques d echantillons
     */
    private $_id;
    private $name;
    private $name_fr;
    private $description;
    private $message_start;
    private $message_end;
    private $questions_group;
    /*
     * date last modified.
     */
    private $last_modified;
    /**
     * contributors are people working on thi squetsionnaire
     */
    private $contributors;

    /**
     * Override Structure method
     * Modified to get new object instead of clone of existing object merged.
     *
     * Get list of structure objects from list of values in mongo document
     *
     * @param string $selector
     * @param string|callable $className Structure class name or closure, which accept data and return string class name of Structure
     * @return object representation of document with class, passed as argument
     * @throws Exception
     */
    public function getObjectList($selector, $className) {
        $data = $this->get($selector);
        if (!$data || !is_array($data)) {
            return array();
        }

        // class name is string
        if (is_string($className)) {

            $structure = new $className();
            if (!($structure instanceof Structure)) {
                throw new Exception('Wrong structure class specified');
            }

            return array_map(function($dataItem) use($className) {
                $struct = new $className();
                return $struct->merge($dataItem);
            }, $data);
        }

        // class name id callable
        if (is_callable($className)) {

            $structurePrototypePool = array();

            return array_map(function($dataItem) use($structurePrototypePool, $className) {

                // get Structure class name from callable
                $classNameString = $className($dataItem);

                // create structure prototype
                if (empty($structurePrototypePool[$classNameString])) {
                    $structurePrototypePool[$classNameString] = new $classNameString;
                    if (!($structurePrototypePool[$classNameString] instanceof Structure)) {
                        throw new Exception('Wrong structure class specified');
                    }
                }

                // instantiate structure from related prototype
                $structure = clone $structurePrototypePool[$classNameString];

                return $structure->merge($dataItem);
            }, $data);
        }

        throw new Exception('Wrong class name specified. Use string or closure');
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getName_fr() {
        return $this->name_fr;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getMessage_start() {
        return $this->message_start;
    }

    public function getMessage_end() {
        return $this->message_end;
    }

    public function getQuestions_group() {
        $result = $this->getObjectList('questions_group', 'AppBundle\Entity\QuestionGroup');
        return $result;
    }

    public function getLast_modified() {
        return $this->last_modified;
    }

    public function getContributors() {
        return $this->contributors;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setName_fr($name_fr) {
        $this->name_fr = $name_fr;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setMessage_start($message_start) {
        $this->message_start = $message_start;
    }

    public function setMessage_end($message_end) {
        $this->message_end = $message_end;
    }

    public function setQuestions_group($questions_group) {
        $this->questions_group = $questions_group;
    }

    public function setLast_modified($last_modified) {
        $this->last_modified = date("d/m/Y", $last_modified->sec);
    }

    public function setContributors($contributors) {
        $this->contributors = $contributors;
    }

    public function renderTabbedGroup($lang) {
        return QuestionnaireHTMLRenderer::renderTabbedGroup($this, $lang, false);
    }

}