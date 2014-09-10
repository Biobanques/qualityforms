<?php

/**
 * Object questionnaire to store a questionnaire definition
 *  * @property integer $id
 * @author nmalservet
 *
 */
class Questionnaire extends EMongoDocument {

    /**
     * champs classiques d echantillons
     */
    public $id;
    public $name;
    public $description;
    public $message_start;
    public $message_end;
    public $questions_group;
    /*
     * date last modified.
     */
    public $last_modified;

    /**
     * contributors are people working on thi squetsionnaire
     */
    public $contributors;

    /**
     * fields to manage add question 
     */
// This has to be defined in every model, this is same as with standard Yii ActiveRecord
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

// This method is required!
    public function getCollectionName() {
        return 'questionnaire';
    }

    public function behaviors() {
        return array('embeddedArrays' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'questions_group', // name of property, that will be used as an array
                'arrayDocClassName' => 'QuestionGroup'  // class name of embedded documents in array
            ),
        );
    }

    public function rules() {
        return array(
            array(
                'id',
                'required'
            ),
            array(
                'id,questions_group',
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

    public function attributeExportedLabels() {

        return array(
            'id' => 'id',
            'questions_group' => 'Questions Group',
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
    public function renderHTML($lang) {
        $result = "";
        foreach ($this->questions_group as $question_group) {
            $result.=$this->renderQuestionGroupHTML($question_group, $lang);
            $result.= "<br><div style=\”clear:both;\"></div>";
        }
        $result.=$this->renderContributors();
        return $result;
    }

    /**
     * render tab associated to each group
     */
    public function renderTabbedGroup($lang) {
        $divTabs = "<ul class=\"nav nav-tabs\" role=\"tablist\">";
        $divPans = "<div class=\"tab-content\">";
        $firstTab=false;
        foreach ($this->questions_group as $question_group) {
            if ($question_group->parent_group == null) {
                //par defaut lang = en
                $title = $question_group->title;
                if ($lang == "fr")
                    {$title = $question_group->title_fr;}
                if ($lang == "both")
                   { $title = "<i>".$question_group->title . "</i><bR> " . $question_group->title_fr;}
                   $extraActive="";
                   $extraActive2="";
                   if($firstTab==false){
                       $firstTab=true;
                       $extraActive="class=\"active\"";
                       $extraActive2=" active";
                   }
                $divTabs.= "<li ".$extraActive."><a href=\"#" . $question_group->id . "\" role=\"tab\" data-toggle=\"tab\">" . $title . "</a></li>";
                $divPans.= " <div class=\"tab-pane ".$extraActive2."\" id=\"" . $question_group->id . "\">" . $this->renderQuestionGroupHTML($question_group, $lang) . "</div>";
            }
        }
        $divPans.="</div>";
        $divTabs.="</ul>";
        return "<div class=\"tabbable\">".$divTabs . $divPans."</div>";
    }

    public function renderQuestionGroupHTML($question_group, $lang) {
        $result = "";
        //en par defaut
        $title=$question_group->title;
        if ($lang == "fr")
            {$title=$question_group->title_fr;}
         if ($lang == "both")
           { $title= "<i>".$question_group->title . "</i> / " . $question_group->title_fr ;}
        $result.="<div class=\"question_group\">" .$title . "</div>";
        if (isset($question_group->questions)) {
            foreach ($question_group->questions as $question) {
                $result.=$this->renderQuestionHTML($question_group->id, $question, $lang);
            }
        }
        //add question groups that have parents for this group
        foreach ($this->questions_group as $qg) {
            if ($qg->parent_group == $question_group->id) {
                $result.=$this->renderQuestionGroupHTML($qg, $lang);
            }
        }
        $result .= "<div class=\"end-question-group\"></div>";
        return $result;
    }

    /*
     * render html the current question.
     */

    public function renderQuestionHTML($idquestiongroup, $question, $lang) {
        $result = "";
        $result.="<div style=\"" . $question->style . "\">";
        //par defaut lang = enif ($lang == "en")
        $label = $question->label;
        if ($lang == "fr")
            {$label = $question->label_fr;}
        if ($lang == "both")
           { $label = "<i>".$question->label . "</i><br>" . $question->label_fr;}

        $result.="<div class=\"question-label\" >" . $label;
        if (isset($question->help)) {
            // $result.="ddd<span class=\"glyphicon glyphicon-help\"></span>";
            $result.=HelpDivComponent::getHtml("help-" . $question->id, $question->help);
            /* $result.=$this->widget('bootstrap.widgets.TbButton', array(
              'label' => '?',
              'type' => 'info',
              'htmlOptions' => array('data-title' => 'Help/Aide', 'data-content' => $question->help, 'rel' => 'popover'),
              )); */
        }
        $result.="</div>";
        $result.="<div class=\"question-input\">";

        //affichage de l input selon son type
        $idInput = "id=\"" . $idquestiongroup . "_" . $question->id . "\" name=\"Questionnaire[" . $idquestiongroup . "_" . $question->id . "]\"";
        if ($question->type == "input") {
            $result.="<input type=\"text\" " . $idInput . "/>";
        }
        if ($question->type == "radio") {

            if ($lang == "fr" && $question->values_fr != "")
                $values = $question->values_fr;
            else
                $values = $question->values;
            $arvalue = split(",", $values);
            foreach ($arvalue as $value) {
                $result.="<input type=\"radio\" " . $idInput . " value=\"" . $value . "\">&nbsp;" . $value . "</input>&nbsp;";
            }
        }
        if ($question->type == "checkbox") {
            $values = $question->values;
            if ($lang == "fr" && isset($question->values_fr))
                $values = $question->values_fr;
            $arvalue = split(",", $values);
            foreach ($arvalue as $value) {
                $result.="<input type=\"checkbox\" " . $idInput . " value=\"" . $value . "\">&nbsp;" . $value . "</input><br>";
            }
        }
        if ($question->type == "text") {
            $result.="<textarea rows=\"4\" cols=\"250\" " . $idInput . " style=\"width: 500px; height: 70px;\"></textarea>";
        }
        if ($question->type == "image") {
            $result.="<div style=\"width:200px;height:100px;backgournd-color:#CDBFC2;\">Put your picture here/ Placer votre image ici.<br><i>Feature to upload picture in development.</i> </div>";
        }
        if ($question->type == "list") {
            $values = $question->values;
            $arvalue = split(",", $values);
            $result.="<select " . $idInput . ">";
            $result.="<option  value=\"\"></option>";
            foreach ($arvalue as $value) {
                $result.="<option  value=\"" . $value . "\">" . $value . "</option>";
            }
            $result.="</select>";
        }
        if ($question->type == "array") {
            $rows = $question->rows;
            $arrows = split(",", $rows);
            $cols = $question->columns;
            $arcols = split(",", $cols);
            $result.="<table><tr><td></td>";
            foreach ($arcols as $col) {
                $result.="<td>" . $col . "</td>";
            }
            $result.="</tr>";
            foreach ($arrows as $row) {
                $result.="<tr><td>" . $row . "</td>";
                foreach ($arcols as $col) {
                    $idunique = $idquestiongroup . "_" . $question->id . "_" . $row . "_" . $col;
                    $idInput = "id=\"" . $idunique . "\" name=\"Questionnaire[" . $idunique . "]\"";
                    $result.="<td><input type=\"text\" " . $idInput . "/></td>";
                }
                $result.="</tr>";
            }
            $result.="</table>";
        }
        //close question input
        $result.="</div>";
        //close row input
        $result.="</div>";
        return $result;
    }

    /**
     * update questionnaire with fields filled.
     * Add question group if necessary
     */
    public function updateForm($questionnaireGroupForm) {
        $result = false;
        //check if fields required are filled
        if ($questionnaireGroupForm->validate()) {
            $qg = new QuestionGroup;
            $qg->id = $questionnaireGroupForm->formQuestionGroupId;
            $qg->title = $questionnaireGroupForm->formQuestionGroupTitle;
            $qg->title_fr = $questionnaireGroupForm->formQuestionGroupTitleFr;
            $this->questions_group[] = $qg;
            $this->save();
            $result = true;
        }
        return $result;
    }

    /**
     * render contributors
     * used in plain page and tab page
     * @return string
     */
    public function renderContributors() {
        $result = "<div><div class=\"question_group\"><i>Contributors</i> / Contributeurs</div>";
        $result.="<div class=\"span5\">" . $this->contributors . "</div>";
        $result.="</div>";
        return $result;
    }

}

?>