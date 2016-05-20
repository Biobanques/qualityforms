<?php

namespace AppBundle\Entity;

use Sokil\Mongo\Exception;
use Sokil\Mongo\Structure;
use AppBundle\Entity\AnswerQuestion;

/**
 * classe embarquée AnswerGroup, définit les objets Question dans les questionnaires
 * @author matthieu
 *
 */
class AnswerGroup extends Structure
{
    protected $id;
    protected $title;
    protected $title_fr;
    protected $answers;
    /**
     * parent group if setted.
     * @var type
     */
    protected $parent_group;
    /**
     * rule to add condition on display of an element
     * @var type
     */
    protected $display_rule;

    public function getId() {
        return $this->get('id');
    }

    public function getTitle() {
        return $this->title;
    }

    public function getTitle_fr() {
        return $this->title_fr;
    }

    public function getAnswers() {
        return $this->getObjectList('answers', 'AppBundle\Entity\AnswerQuestion');
    }

    public function getParent_group() {
        return $this->parent_group;
    }

    public function getDisplay_rule() {
        return $this->display_rule;
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
     * copy attributes of questionGroup recursively to the final state answer-question.
     * @param type $questionnaire
     */
    public function copy($questionGroup) {
        $this->set('id', $questionGroup->id);
        $this->set('title', $questionGroup->title);
        $this->set('title_fr', $questionGroup->title_fr);
        $this->set('parent_group', $questionGroup->parent_group);
        $this->set('display_rule', $questionGroup->display_rule);
        $this->set('answers', []);
        foreach ($questionGroup->getQuestions() as $question) {
            $aq = new AnswerQuestion;
            $aq->copy($question);
            $answers = $this->get('answers');
            $answers[] = $aq;
            $this->set('answers', $answers);
        }
    }

}