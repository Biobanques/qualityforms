<?php
/* @var $this EchantillonController */
/* @var $model Echantillon */

$this->breadcrumbs = array(
    'Questionnaires' => array('index'),
    $model->id,
);
?>

<h1>View Questionnaire ( One printable page) #<?php echo $model->id; ?></h1>


<?php
//
echo $model->renderHTML(Yii::app()->language);
?>
