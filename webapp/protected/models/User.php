<?php

/**
 * Object to store basic user
 * @author nmalservet
 *
 */
class User extends EMongoDocument {

    /**
     * 
     */
    public $login;
    /**
     *embedded document with array of QuestionAnswer
     * @var type 
     */
    public $password;

    // This has to be defined in every model, this is same as with standard Yii ActiveRecord
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    // This method is required!
    public function getCollectionName() {
        return 'user';
    }

    public function rules() {
        return array(
            array('login, password', 'required'),
            array(
                'login',
                'safe',
                'on' => 'search'
            )
        );
    }

       /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'login' => Yii::t('common', 'Login'),
            'password' => Yii::t('common', 'password'),
        );
    }


    public function search($caseSensitive = false) {
        $criteria = new EMongoCriteria ();
        if (isset($this->login) && !empty($this->login)) {
            $criteria->login = "" . $this->login . "";
        }

        Yii::app()->session['criteria'] = $criteria;
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

   
    

}

?>