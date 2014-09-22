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
<?php
 //echo CHtml::link('Export PDF',array('questionnaire/exportPDF','id'=>$model->_id)); 
 //$image = CHtml::image( 'images/x.png', 'Delete', array('title'='Export'));
$img = CHtml::image(Yii::app()->request->baseUrl.'/images/page_white_acrobat.png','export as pdf'); 
echo CHtml::link($img, array('questionnaire/exportPDF','id'=>$model->_id), array());
?>
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
<div>
    <?php
    
    echo $model->renderTabbedGroup(Yii::app()->language);
?>
</div>
    <?php
?>
    
