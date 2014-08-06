<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>
<div class="row-fluid">
    <div class="span2">
        <?php
        echo CHtml::image("./images/logobb.png", "Biobanques");
        ?>
    </div>
    <div class="span10">
        <?php
        $this->beginWidget('bootstrap.widgets.TbHeroUnit', array(
            'heading' => 'Welcome to ' . CHtml::encode(Yii::app()->name),
        ));
        ?>
        Quality forms allow you to manage follow-up of biological samples with specifc forms built by the WP2 of the common infrsatructure Biobanques.
        <?php $this->endWidget(); ?>
    </div>
</div>



<div class="row-fluid">
    <div class="span4">
        <h2>Deposit form</h2>
        <p class="text-danger">Under construction.</p>
        <p>Deposit form allow you to enhance quality around human biological samples.<br>
            For DNA/RNA, cells, fluids and tissues.</p>
        <p><a class="btn btn-primary" href="#" role="button">View the form »</a></p>
    </div>
    <div class="span4">
        <h2>Release form</h2>
        <p>Release form allow you to follow-up your quality transaction around biological samples. </p>
        <p><a class="btn btn-primary" href="#" role="button">View the form »</a></p>
    </div>
    <div class="span4" >
        <h2>Deposit form for microorganisms</h2>
        <p>Deposit form for microrganisms.</p>
        <p><a class="btn btn-primary" href="#" role="button">View the form »</a></p>
    </div>
</div>
