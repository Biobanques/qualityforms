<?php
/* @var $this EchantillonController */
/* @var $model Echantillon */

$this->breadcrumbs=array(
	'Questionnaires'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
?>

<h1>Update Questionnaire <?php echo $model->id; ?></h1>

<?php 
//echo $this->renderPartial('_form', array('model'=>$model)); ?>