<?php

namespace AppBundle\Entity;

use Sokil\Mongo\Structure;

/**
 * classe embarquée Question, définit les objets Question dans les questionnaires
 * @author matthieu
 *
 */
class QuestionGroup extends Structure
{
    private $id;
    private $title;
    private $title_fr;
    //private $questions;
    /**
     * parent group if setted.
     * @var type
     */
    private $parent_group;
    /**
     * display rule
     * condition to display the question group
     * @return type
     */
    private $display_rule;

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
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getTitle_fr() {
        return $this->title_fr;
    }

//    public function getQuestions() {
//        return $this->questions;
//    }

    public function getParent_group() {
        return $this->parent_group;
    }

    public function getDisplay_rule() {
        return $this->display_rule;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setTitle_fr($title_fr) {
        $this->title_fr = $title_fr;
    }

//    public function setQuestions($questions) {
//        $this->questions = $questions;
//    }

    public function setParent_group(type $parent_group) {
        $this->parent_group = $parent_group;
    }

    public function setDisplay_rule($display_rule) {
        $this->display_rule = $display_rule;
    }

//    public function behaviors() {
//        return array('embeddedArrays' => array(
//                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
//                'arrayPropertyName' => 'questions', // name of property, that will be used as an array
//                'arrayDocClassName' => 'Question'  // class name of embedded documents in array
//            ),
//        );
//    }

    public function getQuestions() {
        return $this->getObjectList('questions', 'AppBundle\Entity\Question');
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

//    /**
//     *
//     * @return array customized attribute labels (name=>label)
//     */
//    public function attributeLabels() {
//        return array(
//            'id' => 'Id',
//            'title' => 'title',
//            'title_fr' => 'titre',
//            'parent_group' => 'parent_group'
//        );
//    }

    /**
     * TODO : display rule dinammcally ( with JS)
     * make the javascript display rule.
     */
    public function makeDisplayRule() {

    }

}