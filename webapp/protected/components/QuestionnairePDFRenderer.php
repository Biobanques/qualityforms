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
class QuestionnairePDFRenderer {
    
    
    public static $LINE_HEIGHT=7;

    public static function render($questionnaire) {
        require_once(Yii::getPathOfAlias('application.vendor') . '/tcpdf/tcpdf.php');
// create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Biobanques');
        $pdf->SetTitle($questionnaire->name);
        $pdf->SetSubject($questionnaire->name);
        $pdf->SetKeywords('Biobanques, PDF, quality, form' . $questionnaire->name);
// set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        /* if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
          require_once(dirname(__FILE__) . '/lang/eng.php');
          $pdf->setLanguageArray($l);
          } */
// ---------------------------------------------------------
// IMPORTANT: disable font subsetting to allow users editing the document
        $pdf->setFontSubsetting(false);
// set font
        $pdf->SetFont('helvetica', '', 8, '', false);
// add a page
        $pdf->AddPage();
        //form default properties
        $pdf->setFormDefaultProp(array('lineWidth' => 1, 'borderStyle' => 'solid', 'fillColor' => array(200, 200, 200), 'strokeColor' => array(255, 128, 128)));

        $pdf->SetFont('helvetica', 'B', 18);
        $pdf->Cell(0, 5, 'Biobanques Quality Form ', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf = QuestionnairePDFRenderer::renderPDF($pdf, $questionnaire, "fr");

// output the HTML content
        // $pdf->writeHTML($html, true, false, true, false);
// reset pointer to the last page
        $pdf->lastPage();

// ---------------------------------------------------------
//Close and output PDF document
        $pdf->Output('biobanques_qualityform_' . $questionnaire->id . '.pdf', 'D');
    }

    /**
     * render contributors
     * used in plain page and tab page
     * @return string
     */
    public function renderContributors($pdf, $contributors) {
        $pdf->AddPage();
        $pdf->Cell(0, 5, 'Contributors / Contributeurs', 0, 1, 'C');
// Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $contributors, 0, 1, 0, true, '', true);
        return $pdf;
    }

    /**
     * render in xhtml the questionnaire to the pdf output
     */
    public static function renderPDF($pdf, $questionnaire, $lang) {
        foreach ($questionnaire->questions_group as $question_group) {
            //$pdf->AddPage();
            if ($question_group->parent_group == "") {
                // set a bookmark for the current position
                $pdf->AddPage();
                $pdf->Bookmark($question_group->title_fr, 0, 0, '', 'B', array(0,64,128));
                $pdf = QuestionnairePDFRenderer::renderQuestionGroupPDF($pdf, $questionnaire, $question_group, $lang, false);
            }
        }
        $pdf = QuestionnairePDFRenderer::renderContributors($pdf, $questionnaire->contributors);
        return $pdf;
    }

    /**
     * render a question group or an answer group.
     * @param type $questionnaire or answer
     * @param type $question_group
     * @param type $lang
     * @param type $isAnswered
     * @return string
     */
    public function renderQuestionGroupPDF($pdf, $questionnaire, $group, $lang, $isAnswered) {
        $pdf->Ln(10);
        //en par defaut
        $title = $group->title;
        if ($lang == "fr") {
            $title = $group->title_fr;
        }
        if ($lang == "both") {
            $title = "<i>" . $group->title . "</i> / " . $group->title_fr;
        }
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetFillColor(211, 211, 211);	
        $pdf->Cell(0, 5, $title, 0 , 2, 'L',true);
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', '', 12);
        if (isset($group->questions)) {
            foreach ($group->questions as $question) {
                $pdf = QuestionnairePDFRenderer::renderQuestionPDF($pdf, $group->id, $question, $lang, $isAnswered);
            }
        }
        //add question groups that have parents for this group
        if ($isAnswered)
            $groups = $questionnaire->answers_group;
        else
            $groups = $questionnaire->questions_group;
        foreach ($groups as $qg) {
            if ($qg->parent_group == $group->id) {
                $pdf = QuestionnairePDFRenderer::renderQuestionGroupPDF($pdf, $questionnaire, $qg, $lang, $isAnswered);
            }
        }
        return $pdf;
    }

    /*
     * render html the current question.
     */

    public function renderQuestionPDF($pdf, $idquestiongroup, $question, $lang, $isAnswered) {
        //par defaut lang = enif ($lang == "en")
        $label = $question->label;
        if ($lang == "fr") {
            $label = $question->label_fr;
        }
        if ($lang == "both") {
        $label = $question->label;
            //$label = "<i>" . $question->label . "</i><br/>" . $question->label_fr;
        }
        if ($question->style != "float:right") {
            $pdf->Ln(7);
        }
        if (strlen($label) > 25) {
            $pdf->Cell(50, 5, substr($label, 0, 25).".");
            }else
            $pdf->Cell(50, 5, $label);
        //affichage de l input selon son type
        $id = $idquestiongroup . "_" . $question->id;
        if ($question->type == "input") {
            $pdf->TextField($id, 40, 5);
        }
        if ($question->type == "radio") {
            if ($lang == "fr" && $question->values_fr != "") {
                $values = $question->values_fr;
            } else {
                $values = $question->values;
            }
            $arvalue = split(",", $values);
            foreach ($arvalue as $value) {
                $pdf->RadioButton($id, 5, array(), array(), $value);
                $pdf->Cell(20, 5, $value);
            }
        }
        if ($question->type == "checkbox") {
            $pdf->Ln(10);
            $values = $question->values;
            if ($lang == "fr" && isset($question->values_fr)) {
                $values = $question->values_fr;
            }
            $arvalue = split(",", $values);
            foreach ($arvalue as $value) {
                $pdf->Cell(20, 5, "");
                $pdf->CheckBox($id."_".$value, 5, false, array(), array(), $value);
                $pdf->Cell(35, 5, $value);
                $pdf->Ln(10);
            }
        }
        if ($question->type == "text") {
            $pdf->TextField($id, 60, 18, array('multiline' => true, 'lineWidth' => 0, 'borderStyle' => 'none'), array('v' => '', 'dv' => ''));
            $pdf->Ln(19);
        }
        if ($question->type == "image") {
            //TODO ameliorer le rendu des images et leur integration
            $pdf->Image('images/gnome_mime_image.png', '', '', '', '', 'PNG', '', '', true, 100);
        $pdf->Ln(10);
            
        }
        if ($question->type == "list") {
            $values = $question->values;
            $arvalue = split(",", $values);
            $arrValuesPDF = array();
            $arrValuesPDF[''] = '-';
            foreach ($arvalue as $value) {
                $arrValuesPDF[$value] = $value;
            }
            $pdf->ComboBox($id, 30, 5, $arrValuesPDF);
        }

        if ($question->type == "array") {
            $pdf->Ln(6);
            $rows = $question->rows;
            $arrows = split(",", $rows);
            $cols = $question->columns;
            $arcols = split(",", $cols);
            //$result.="<table><tr><td></td>";
            foreach ($arcols as $col) {
              //  $result.="<td>" . $col . "</td>";
           $pdf->Cell(35, 5, $col);
                }
                $pdf->Ln(6);
            //$result.="</tr>";
            foreach ($arrows as $row) {
                //$result.="<tr><td>" . $row . "</td>";
                $pdf->Cell(35, 5, $row);
                foreach ($arcols as $col) {
                    $idunique = $idquestiongroup . "_" . $question->id . "_" . $row . "_" . $col;
                    $pdf->TextField($idunique, 50, 5);
                }
               // $result.="</tr>";
                $pdf->Ln(6);
            }
           // $result.="</table>";
        }
        return $pdf;
    }

}
