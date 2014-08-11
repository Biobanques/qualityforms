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
 echo CHtml::link('Vue une page HTML',array('questionnaire/viewOnePage','id'=>$model->_id)); ;
?>
<br><bR>
<?php echo CHtml::errorSummary($model,null,null,array('class'=>'alert alert-error')); ?>
<div class="form">
<?php
 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'questionnaire-form',
	'enableAjaxValidation'=>false,
)); 

echo "<div style=\"text-align:center\">".CHtml::submitButton('Save')."</div>"; 
?><br>
<div>
    <?php
    
$this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>$model->renderArrayTabGroup(),
    // additional javascript options for the tabs plugin
    'options'=>array(
        'collapsible'=>true,
    ),
));
?>
</div>
    <?php

$this->endWidget();
?>
    
</div>
