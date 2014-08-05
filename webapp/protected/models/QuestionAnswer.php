<?php

/**
 * embedded class question-answer, store question id and ansswer filled
 * @author nmalservet
 *
 */
class QuestionAnswer extends EMongoEmbeddedDocument {
	public $groupidquestionid;
	public $answer;
        

	/**
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array (
				array (
						'groupidquestionid',
						'required'
				));
	}		


	/**
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array (
				'groupidquestionid' => 'groupidquestionid',
				'answer' => 'answer',
		);
	}

}