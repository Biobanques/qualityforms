<?php

namespace AppBundle\Entity;

use AppBundle\Renderer\QuestionnaireHTMLRenderer;
use Sokil\Mongo\Document;
use Sokil\Mongo\Exception;
use Sokil\Mongo\Structure;

/*
 * @author mpenicaud
 * @codeCoverageIgnore
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
     *
     * @return array
     */
    public function getQuestions_group() {
        $result = $this->getObjectList('questions_group', 'AppBundle\Entity\QuestionGroup');
        return $result;
    }

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

}