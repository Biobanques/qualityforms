<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array(
    'heading'=>'Welcome to '.CHtml::encode(Yii::app()->name),
)); ?>


<?php $this->endWidget(); ?>

<div>Quality forms allow you to manage follow-up of biological samples with specifc forms built by the WP2 of the common infrsatructure Biobanques.</div>

<div>Deposit form</div>
