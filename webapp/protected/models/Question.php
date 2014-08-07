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