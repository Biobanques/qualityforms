<?php
$this->breadcrumbs=array(
	'Questionnaires',
);
?>
<h1>Questionnaires</h1>
<div>List of questionnaires available.  </div>
<?php
 $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$dataProvider,
    'template'=>"{items}",
    'columns'=>array(
        array('name'=>'id', 'header'=>'#'),
        array('name'=>'questionnaire', 'header'=>'questionnaire'),
        array('name'=>'description', 'header'=>'description'),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),
    ),
)); ?>

