<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuestionnaireHTMLRenderer
 * render to display elements of questionnaire
 * @author nicolas
 */
class QuestionnaireHTMLRenderer {

    /**
     * render contributors
     * used in plain page and tab page
     * @return string
     */
    public function renderContributors($contributors) {
        $result = "<div><div class=\"question_group\"><i>Contributors</i> / Contributeurs</div>";
        $result.="<div class=\"span5\">" . $contributors . "</div>";
        $result.="</div>";
        return $result;
    }

    /**
     * render tab associated to each group for a questionnaire
     * if isAnswered is filled, we are in case of answer.
     */
    public function renderTabbedGroup($questionnaire, $lang, $isAnswered) {
        $divTabs = "<ul class=\"nav nav-tabs\" role=\"tablist\">";
        $divPans = "<div class=\"tab-content\">";
        $firstTab = false;
        if ($isAnswered) {
            $groups = $questionnaire->answers_group;
        } else {
            $groups = $questionnaire->questions_group;
        }
        foreach ($groups as $group) {
            if ($group->parent_group == null) {
                //par defaut lang = en
                $title = $group->title;
                if ($lang == "fr") {
                    $title = $group->title_fr;
                }
                if ($lang == "both") {
                    $title = "<i>" . $group->title . "</i><bR> " . $group->title_fr;
                }
                $extraActive = "";
                $extraActive2 = "";
                if ($firstTab == false) {
                    $firstTab = true;
                    $extraActive = "class=\"active\"";
                    $extraActive2 = " active";
                }
                $divTabs.= "<li " . $extraActive . "><a href=\"#" . $group->id . "\" role=\"tab\" data-toggle=\"tab\">" . $title . "</a></li>";
                $divPans.= " <div class=\"tab-pane " . $extraActive2 . "\" id=\"" . $group->id . "\">" . QuestionnaireHTMLRenderer::renderQuestionGroupHTML($questionnaire, $group, $lang, $isAnswered) . "</div>";
            }
        }
        $divPans.="</div>";
        $divTabs.="</ul>";
        return "<div class=\"tabbable\">" . $divTabs . $divPans . "</div>";
    }

    /**
     * render a question group or an answer group.
     * @param type $questionnaire or answer
     * @param type $question_group
     * @param type $lang
     * @param type $isAnswered
     * @return string
     */
    public function renderQuestionGroupHTML($questionnaire, $group, $lang, $isAnswered) {
        $result = "";
        //en par defaut
        $title = $group->title;
        if ($lang == "fr") {
            $title = $group->title_fr;
        }
        if ($lang == "both") {
            $title = "<i>" . $group->title . "</i> / " . $group->title_fr;
        }
        $result.="<div class=\"question_group\">" . $title . "</div>";
        if ($isAnswered) {
            $quests = $group->answers;
        } else {
            $quests = $group->questions;
        }
        if (isset($quests)) {
            foreach ($quests as $question) {
                $result.=QuestionnaireHTMLRenderer::renderQuestionHTML($group->id, $question, $lang, $isAnswered);
            }
        }
        //add question groups that have parents for this group
        if ($isAnswered) {
            $groups = $questionnaire->answers_group;
        } else {
            $groups = $questionnaire->questions_group;
        }
        foreach ($groups as $qg) {
            if ($qg->parent_group == $group->id) {
                $result.=QuestionnaireHTMLRenderer::renderQuestionGroupHTML($questionnaire, $qg, $lang, $isAnswered);
            }
        }
        $result .= "<div class=\"end-question-group\"></div>";
        return $result;
    }

    /*
     * render html the current question.
     */

    public function renderQuestionHTML($idquestiongroup, $question, $lang, $isAnswered) {
        $result = "";   
        $style="style=\"\"";
        if ($question->style != "") {
            $style = "style=\"" . $question->style . "\"";
        }
        $result.="<div ".$style.">";
        if ($question->precomment != null) {
            $precomment = $question->precomment;
            if ($lang == "fr") {
                $precomment = $question->precomment_fr;
            }
            if ($lang == "both") {
                $precomment = "<i>" . $question->precomment . "</i><br>" . $question->precomment_fr;
            }
            $result.="<div class=\"question-precomment\">" . $precomment . "</div>";
        }
        //par defaut lang = enif ($lang == "en")
        $label = $question->label;
        if ($lang == "fr") {
            $label = $question->label_fr;
        }
        if ($lang == "both") {
            $label = "<i>" . $question->label . "</i><br>" . $question->label_fr;
        }

        $result.="<div class=\"question-label\" >" . $label;
        if (isset($question->help)) {
            $result.=HelpDivComponent::getHtml("help-" . $question->id, $question->help);
        }
        $result.="</div>";
        $result.="<div class=\"question-input\">";

        //affichage de l input selon son type
        $idInput = "id=\"" . $idquestiongroup . "_" . $question->id . "\" name=\"Questionnaire[" . $idquestiongroup . "_" . $question->id . "]" . ($question->type == "checkbox" ? "[]" : "") . "\"";
        $valueInput = "";
        if ($isAnswered) {
            $valueInput = $question->answer;
        }
        if ($question->type == "input") {
            $result.="<input type=\"text\" " . $idInput . " value=\"" . $valueInput . "\"/>";
        }
        if ($question->type == "radio") {

            if ($lang == "fr" && $question->values_fr != "") {
                $values = $question->values_fr;
            } else {
                $values = $question->values;
            }
            $arvalue = split(",", $values);

            foreach ($arvalue as $value) {
                $result.="<input type=\"radio\" " . $idInput . " value=\"" . $value . "\" " . ($value == $valueInput ? 'checked' : '') . ">&nbsp;" . $value . "</input>&nbsp;";
            }
        }
        if ($question->type == "checkbox") {
            $values = $question->values;
            if ($lang == "fr" && isset($question->values_fr)) {
                $values = $question->values_fr;
            }
            $arvalue = split(",", $values);
            foreach ($arvalue as $value) {
                $checked = false;
                //in case of check box $ValuesInput is stored into an array.
                if ($valueInput != null) {
                    foreach ($valueInput as $vInput) {
                        if ($vInput == $value) {
                            $checked = true;
                        }
                    }
                }
                $result.="<input type=\"checkbox\" " . $idInput . " value=\"" . $value . "\" " . ($checked ? 'checked' : '') . ">&nbsp;" . $value . "</input><br>";
            }
        }
        if ($question->type == "text") {
            $result.="<textarea rows=\"4\" cols=\"250\" " . $idInput . " style=\"width: 645px; height: 70px;\" >" . $valueInput . "</textarea>";
        }
        if ($question->type == "image") {
            if ($isAnswered) {
                $result.="<input ".$idInput." type=\"file\" />";
            
                if ($question->answer != null) {
                    $result.="<div>here the image</div>";
                }
            }
            else {
                $result.="<div style=\"width:128px;height:128px;background-repeat:no-repeat;background-image:url('http://localhost/qualityforms/images/gnome_mime_image.png');\"> </div>";
            }
        }
        if ($question->type == "list") {
            $values = $question->values;
            $arvalue = split(",", $values);
            $result.="<select " . $idInput . ">";
            $result.="<option  value=\"\"></option>";
            foreach ($arvalue as $value) {
                $result.="<option  value=\"" . $value . "\" " . ($valueInput == $value ? 'selected' : '') . ">" . $value . "</option>";
            }
            $result.="</select>";
        }
        //close question input
        $result.="</div>";
        //close row input
        $result.="</div>";
        return $result;
    }

}
