<?php

/**
 * classe embarquée Question, définit les objets Question dans les questionnaires
 * @author matthieu
 *
 */
class Question extends EMongoEmbeddedDocument {
	public $id;
	public $label;
        public $label_fr;
        public $type;
        /*
         * css style applied to the label.
         */
        public $style;
	/**
         * values if question type is radio
         */
        public $values;
        
        /**
         * help text to add meta information around the question, displayed as an help button
         * @var type 
         */
        public $help;
        
        /**
         *columns if type is array
         * @var type 
         */
        public $columns;
        /**
         * rows if type is array
         * @var type 
         */
        public $rows;

	/**
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array (
				array (
						'id',
						'required'
				));
	}		


	/**
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array (
				'id' => 'Id',
				'label' => 'question',
                                'label_fr' => 'question',
		);
	}
        
        

}