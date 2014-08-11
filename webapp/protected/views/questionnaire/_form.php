<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'questionnaireGroup-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('common','ChampsObligatoires'); ?></p>

	<?php 
        
        echo $form->errorSummary($model,null,null,array('class'=>'alert alert-error')); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'formQuestionGroupId'); ?>
		<?php echo $form->textField($model,'formQuestionGroupId',array('size'=>5,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'formQuestionGroupId'); ?>
	</div>
    <div class="row">
		<?php echo $form->labelEx($model,'formQuestionGroupTitle'); ?>
		<?php echo $form->textField($model,'formQuestionGroupTitle',array('size'=>5,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'formQuestionGroupTitle'); ?>
	</div>
    <div class="row">
		<?php echo $form->labelEx($model,'formQuestionGroupTitleFr'); ?>
		<?php echo $form->textField($model,'formQuestionGroupTitleFr',array('size'=>5,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'formQuestionGroupTitleFr'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->