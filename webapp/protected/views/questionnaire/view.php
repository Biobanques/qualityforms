<?php
/* @var $this EchantillonController */
/* @var $model Echantillon */

$this->breadcrumbs = array(
    'Questionnaires' => array('index'),
    $model->id,
);
?>

<h1>View Questionnaire #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
    ),
));
?>

<?php
//
foreach ($model->questions_group as $question_group) {
   // echo "<div>id" . $question_group->id . "</div>";
    //echo "<div style=\"border:1px solid blue;\">";
    echo "<div class=\"question_group\"><i>" . $question_group->title . "</i> / ".$question_group->title_fr."</div>";
    foreach ($question_group->questions as $question) {
        echo "<div  style=\"".$question->style."\">";
         echo "<div class=\"question-label\" ><i>" . $question->question . "</i><br>".$question->question_fr."</div>";
       // echo "</div>";
        echo "<div class=\"question-input\">";
        //affichage de l input selon son type
        if($question->type=="input"){
            echo "<input type=\"text\" name=\"".$question_group->id."_".$question->id."\">";
        }
        echo"</div>";
        echo "</div>";
    }
    //echo "</div>";
    echo "<br><div style=\”clear:both;\"></div>";
}
?>
