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
<?php
echo CHtml::beginForm(); 
echo "<div style=\"text-align:center\">".CHtml::submitButton('Save')."</div>"; 
echo "<br>";
$this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>$model->renderArrayTabGroup(),
    // additional javascript options for the tabs plugin
    'options'=>array(
        'collapsible'=>true,
    ),
));



echo CHtml::endForm();
?>
