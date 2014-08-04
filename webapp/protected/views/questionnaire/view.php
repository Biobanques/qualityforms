<?php
/* @var $this EchantillonController */
/* @var $model Echantillon */

$this->breadcrumbs=array(
	'Questionnaires'=>array('index'),
	$model->id,
);
?>

<h1>View Questionnaire #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
	),
)); ?>

<?php
//affichage des groupes de questions
echo "nb groupes:".count($model->questions_group);
//
foreach ($model->questions_group as $question_group) {
    echo "id".$question_group->id;
     echo "title".$question_group->title;
}
?>
