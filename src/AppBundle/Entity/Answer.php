<?php

namespace AppBundle\Entity;

use AppBundle\Renderer\QuestionnaireHTMLRenderer;
use Sokil\Mongo\Document;
use Sokil\Mongo\Exception;
use Sokil\Mongo\Structure;
use AppBundle\Entity\AnswerGroup;

/**
 * Object answer to store a questionnaire definition + answers
 * Copy of object questionnaire to prevent problems of update with questionnaire and forwar compatibility
 * @property integer $id
 * @author mpenicaud
 * @codeCoverageIgnore
 */
class Answer extends Document
{
    /**
     * equal id of the questionnaire
     * @var type
     */
    private $_id;
    /**
     * user unique login filling this answer.
     */
    private $login;
    /*
     * unique id of the questionnaire
     */
    private $questionnaireMongoId;
    private $name;
    /**
     * field last modified from the questionnaire source.
     * @var type
     */
    private $last_modified;
    private $description;
    private $message_start;
    private $message_end;
    private $answers_group;
    /*
     * last date of save action
     */
    private $last_updated;
    /**
     * contributors are people working on thi squetsionnaire
     */
    private $contributors;

    public function getAnswers_group() {
        $result = $this->getObjectList('answers_group', 'AppBundle\Entity\AnswerGroup');
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

    public function rules() {
        return array(
            array(
                'id,login,questionnaireMongoId',
                'required'
            ),
            array(
                'id,answers_group',
                'safe',
                'on' => 'search'
            )
        );
    }

    /**
     * copy attributes of questionnaire recursively to the final state answer-question.
     * @param type $questionnaire
     */
    public function copy($questionnaire) {
        $this->set('id', $questionnaire->id);
        $this->set('questionnaireMongoId', $questionnaire->_id);
        $this->set('name', $questionnaire->name);
        $this->set('description', $questionnaire->description);
        $this->set('message_start', $questionnaire->message_start);
        $this->set('message_end', $questionnaire->message_end);
        $this->set('last_modified', $questionnaire->last_modified);
        $this->set('answers_group', []);
        foreach ($questionnaire->getQuestions_group() as $question_group) {
            $answerGroup = new AnswerGroup;
            $answerGroup->copy($question_group);
            $answersGroup = $this->get('answers_group');
            $answersGroup[] = $answerGroup;
            $this->set('answers_group', $answersGroup);
        }
    }

}
?>