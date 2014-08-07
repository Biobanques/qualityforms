<?php
$this->breadcrumbs=array(
	'Questionnaires',
);
?>
<h1>My documents filled</h1>
<div>List of my questionnaires filled.  </div>
<?php
 $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$dataProvider,
    'template'=>"{items}",
    'columns'=>array(
        array('name'=>'id', 'header'=>'#'),
        array('name'=>'questionnaireid', 'header'=>'questionnaire'),
        array('name'=>'last update', 'header'=>'last update'),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),
    ),
)); ?>

