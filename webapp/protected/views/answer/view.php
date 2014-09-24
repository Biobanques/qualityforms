<?php

$this->breadcrumbs = array(
    'My documents' => array('index'),
    $model->id,
);
?>
<h1>View my document #<?php echo $model->id; ?></h1>


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
    echo $model->renderTabbedGroup(Yii::app()->language);
    ?>
</div>
    <?php
    $this->endWidget();
    ?>

</div>
