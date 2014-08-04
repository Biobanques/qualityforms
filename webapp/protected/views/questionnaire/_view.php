
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->_id), array('view', 'id'=>$data->_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::encode($data->id); ?>
	<br />
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('questionnaire')); ?>:</b>
	<?php echo CHtml::encode($data->questionnaire); ?>
	<br />
</div>