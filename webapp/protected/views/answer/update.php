<?php

$this->breadcrumbs = array(
    'Mes documents' => array('index'),
    $model->id,
);
?>
<h1>Fill in Questionnaire #<?php echo $model->id; ?></h1>

<br><bR>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModalContributors')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Contributors</h4>
</div>
 
<div class="modal-body span5" >
    <?php echo $model->renderContributors(); ?>
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Contributors',
    'type'=>'primary',
    'htmlOptions'=>array(
        'data-toggle'=>'modal',
        'data-target'=>'#myModalContributors',
    ),
)); ?>
<?php echo CHtml::errorSummary($model,null,null,array('class'=>'alert alert-error')); ?>
<div class="form">
<?php
 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'questionnaire-form',
	'enableAjaxValidation'=>false,
     'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); 
echo "<div style=\"text-align:center\">".CHtml::submitButton('Save')."</div>"; 
?><br>
<div>
    <?php
    
    echo $model->renderTabbedGroup(Yii::app()->language);
?>
</div>
    <?php

$this->endWidget();
?>
    
</div>
