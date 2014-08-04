<?php

/**
 * classe embarquée Question, définit les objets Question dans les questionnaires
 * @author matthieu
 *
 */
class QuestionGroup extends EMongoEmbeddedDocument {
	public $id;
	public $title;
        public $title_fr;
        public $questions;
        
         public function behaviors() {
        return array('embeddedArrays' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'questions', // name of property, that will be used as an array
                'arrayDocClassName' => 'Question'  // class name of embedded documents in array
            ),
        );
    }

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
				'title' => 'title',
                                'title_fr' => 'titre',
		);
	}

}