<?php

/**
 * Object questionnaire to store a questionnaire definition
 *  * @property integer $id
 * @author nmalservet
 *
 */
class Answer extends EMongoDocument {

    /**
     * 
     */
    public $questionnaireid;
    /**
     *embedded document with array of QuestionAnswer
     * @var type 
     */
    public $questions_answers;

// This has to be defined in every model, this is same as with standard Yii ActiveRecord
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

// This method is required!
    public function getCollectionName() {
        return 'answer';
    }

    public function behaviors() {
        return array('embeddedArrays' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'questions_answers', // name of property, that will be used as an array
                'arrayDocClassName' => 'QuestionAnswer'  // class name of embedded documents in array
            ),
        );
    }
    
    /**
     * add an association answer-question.
     * @param type $question
     * @param type $answer
     */
    public function addAnswer($groupidquestionid,$answer){
        $questionAnswer = new QuestionAnswer;
        $questionAnswer->groupidquestionid=$groupidquestionid;
        $questionAnswer->answer=$answer; 
        $this->questions_answers[]=$questionAnswer;
    }

    public function rules() {
        return array(
            array(
                'questionnaireid',
                'required'
            ),
            array(
                'id,questions_answers',
                'safe',
                'on' => 'search'
            )
        );
    }

    public function attributeLabels() {

        return array(
            'id' => 'id',
        );
    }


    public function search($caseSensitive = false) {
        $criteria = new EMongoCriteria ();
        if (isset($this->questionnaireid) && !empty($this->questionnaireid)) {
            $criteria->id = "" . $this->questionnaireid . "";
        }

        Yii::app()->session['criteria'] = $criteria;
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

   
    

}

?>