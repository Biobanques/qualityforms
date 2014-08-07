<?php

/**
 * Object answer to store a questionnaire definition + answers
 * Copy of object questionnaire to prevent problems of update with questionnaire and forwar compatibility
 * @property integer $id
 * @author nmalservet
 *
 */
class Answer extends EMongoDocument {

    /**
     * 
     */
// This has to be defined in every model, this is same as with standard Yii ActiveRecord
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

// This method is required!
    public function getCollectionName() {
        return 'answer';
    }

    /**
     * equal id of the questionnaire
     * @var type 
     */
    public $id;

    /**
     * user unique login filling this answer.
     */
    public $login;
    /*
     * unique id of the questionnaire
     */
    public $questionnaireMongoId;
    public $name;
    public $description;
    public $message_start;
    public $message_end;
    public $answers_group;

    public function behaviors() {
        return array('embeddedArrays' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'answers_group', // name of property, that will be used as an array
                'arrayDocClassName' => 'AnswerGroup'  // class name of embedded documents in array
            ),
        );
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

    public function attributeLabels() {

        return array(
            'id' => 'id',
        );
    }

    public function search($caseSensitive = false) {
        $criteria = new EMongoCriteria ();
        if (isset($this->id) && !empty($this->id)) {
            $criteria->id = "" . $this->id . "";
        }

        Yii::app()->session['criteria'] = $criteria;
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    /**
     * render in html the questionnaire
     */
    public function renderHTML() {
        $result = "";
        foreach ($this->answers_group as $answer_group) {
            $result.=$this->renderAnswerGroupHTML($answer_group);
            $result.= "<br><div style=\”clear:both;\"></div>";
        }
        return $result;
    }

    /**
     * render an array of association key/question group to display as tab
     */
    public function renderArrayTabGroup() {
        $result = array();
        if ($this->answers_group != null) {
            foreach ($this->answers_group as $answer_group) {
                $result[$answer_group->title] = $this->renderAnswerGroupHTML($answer_group);
            }
        }
        return $result;
    }

    public function renderAnswerGroupHTML($answer_group) {
        $result = "";
        $result.="<div class=\"question_group\"><i>" . $answer_group->title . "</i> / " . $answer_group->title_fr . "</div>";
        foreach ($answer_group->answers as $answer) {
            $result.=$this->renderAnswerHTML($answer_group->id, $answer);
        }
        $result.= "<br><div style=\”clear:both;\"></div>";
        return $result;
    }

    /*
     * render html the current answer.
     */

    public function renderAnswerHTML($idanswergroup, $answer) {
        $result = "";
        $result.="<div  style=\"" . $answer->style . "\">";
        $result.="<div class=\"question-label\" ><i>" . $answer->label . "</i><br>" . $answer->label_fr . "</div>";
        // $result.="</div>";
        $result.="<div class=\"question-input\">";
        //affichage de l input selon son type
        if ($answer->type == "input") {
            //" . $answer->answer . "
            $result.="<input type=\"text\" name=\"" . $idanswergroup . "_" . $answer->id . " value=\"\" \">";
        }
        if ($answer->type == "radio") {
            $values = $answer->values;
            $arvalue = split(",", $values);
            foreach ($arvalue as $value) {
                $result.="<input type=\"radio\" name=\"" . $idanswergroup . "_" . $answer->id . "\" value=\"" . $value . "\">" . $value . "</input>";
            }
        }
        if ($answer->type == "checkbox") {
            $values = $answer->values;
            $arvalue = split(",", $values);
            foreach ($arvalue as $value) {
                $result.="<input type=\"checkbox\" name=\"" . $idanswergroup . "_" . $answer->id . "\" value=\"" . $value . "\">" . $value . "</input>";
            }
        }
        if ($answer->type == "text") {
            $result.="<input type=\"textarea\" rows=\"4\" cols=\"50\" name=\"" . $idanswergroup . "_" . $answer->id . "\" ></input>";
        }
        $result.="</div>";
        $result.="</div>";
        return $result;
    }

    /**
     * add the answer to th ecorrect place into the tree.
     * @param type $answer
     * @param type $answer
     */
    public function addAnswer($groupid, $questionid, $answer) {
        foreach ($this->answers_group as $answer_group) {
            if ($answer_group->id == $groupid) {
                foreach ($answer_group->answers as $answer) {
                    if ($answer->id == $questionid) {
                        $answer->answer = $answer;
                    }
                }
            }
        }
    }

    /**
     * copy attributes of questionnaire recursively to the final state answer-question.
     * @param type $questionnaire
     */
    public function copy($questionnaire) {
        $this->id = $questionnaire->id;
        $this->name = $questionnaire->name;
        $this->description = $questionnaire->description;
        $this->message_start = $questionnaire->message_start;
        $this->message_end = $questionnaire->message_end;
        foreach ($questionnaire->questions_group as $question_group) {
            $answerGroup = new AnswerGroup;
            $answerGroup->copy($question_group);
            $this->answers_group[] = $answerGroup;
        }
    }

}

?>