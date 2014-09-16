<?php
/* @var $this EchantillonController */
/* @var $model Echantillon */

$this->breadcrumbs = array(
    'Questionnaires' => array('index'),
    $model->id,
);
?>
<h1>View My Questionnaire #<?php echo $model->id; ?></h1>


<?php
echo CHtml::link('Vue une page HTML', array('questionnaire/viewOnePage', 'id' => $model->_id));
;
?>
<br><bR>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'questionnaire-form',
        'enableAjaxValidation' => false,
    ));
    echo "<div style=\"text-align:center\">" . CHtml::submitButton('Save') . "<div>";
    echo $model->renderTabbedGroup(Yii::app()->language);
    ?>
</div>
    <?php
    $this->endWidget();
    ?>

</div>
