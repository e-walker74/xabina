<?php

/**
 * This is the model class for table "users_files".
 *
 * The followings are the available columns in table 'users_files':
 * @property integer       $user_id
 * @property string        $name
 * @property string        $ext
 * @property string        $form
 * @property string        $type
 * @property integer       $parent_id
 * @property string        $user_file_name
 * @property integer       $model_id
 * @property string        $document
 * @property integer       $deleted
 * @property string        $document_type
 * @property string        $description
 * @property integer       $file_size
 *
 * @property Users_Files   $parent
 * @property Users_Files[] $childs
 */
class Users_Files extends ActiveRecord
{

    public $cross_id;
    public $cross_category;
    public $cross_comment;

    public static $fileTypes = array(
        'Transactions' => array('count' => 0, 'fileSize' => 20971520, 'ext' => array("jpg", "jpeg", "gif", "png", "pdf", "txt", "doc", "docx"), 'user_check' => 1),
        'Transfers_Outgoing' => array('count' => 0, 'fileSize' => 20971520, 'ext' => array("jpg", "jpeg", "gif", "png", "pdf", "txt", "doc", "docx"), 'user_check' => 1),
        'Transfers_Incoming' => array('count' => 0, 'fileSize' => 20971520, 'ext' => array("jpg", "jpeg", "gif", "png", "pdf", "txt", "doc", "docx"), 'user_check' => 1),
        'Users_Activation' => array('count' => 4, 'fileSize' => 20971520, 'ext' => array("jpg", "jpeg", "gif", "png"), 'user_check' => 1),
        'Users_Activation_1' => array('count' => 4, 'fileSize' => 20971520, 'ext' => array("jpg", "jpeg", "gif", "png"), 'user_check' => 1),
        'Users_Activation_2' => array('count' => 4, 'fileSize' => 20971520, 'ext' => array("jpg", "jpeg", "gif", "png"), 'user_check' => 1),
        'Users_Personal_Edit' => array('count' => 0, 'fileSize' => 20971520, 'ext' => array("jpg", "jpeg", "gif", "png"), 'user_check' => 1),
        'Form_Outgoingtransf_Own' => array('count' => 0, 'fileSize' => 20971520, 'ext' => array("jpg", "jpeg", "gif", "png", "pdf", "txt", "doc", "docx"), 'user_check' => false),
        'Form_Outgoingtransf_Anather' => array('count' => 0, 'fileSize' => 20971520, 'ext' => array("jpg", "jpeg", "gif", "png", "pdf", "txt", "doc", "docx"), 'user_check' => false),
        'Form_Outgoingtransf_External' => array('count' => 0, 'fileSize' => 20971520, 'ext' => array("jpg", "jpeg", "gif", "png", "pdf", "txt", "doc", "docx"), 'user_check' => false),
        'Form_Outgoingtransf_Ewallet' => array('count' => 0, 'fileSize' => 20971520, 'ext' => array("jpg", "jpeg", "gif", "png", "pdf", "txt", "doc", "docx"), 'user_check' => false),
        'Form_Invoice' => array('count' => 0, 'fileSize' => 20971520, 'ext' => array("jpg", "jpeg", "gif", "png"), 'user_check' => false),
    );

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users_files';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required', 'except' => array('memo')),
            array('ext', 'required', 'except' => array('folder', 'memo')),
            array('user_id', 'required'),
            array('user_id, parent_id, file_size', 'numerical', 'integerOnly' => true),
            array('name, form, document_type, document', 'length', 'max' => 30, 'message' => Yii::t('Front', 'Entry is to long')),
            array('user_file_name', 'length', 'max' => 255, 'tooLong' => Yii::t('Front', 'The comment is too long. It should be no longer than 250 symbols.')),
            array('ext', 'length', 'max' => 11),
//            array('description', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_id, name, ext, user_file_name, type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'personal_document' => array(self::HAS_ONE, 'Users_Personal_Documents', 'file_id'),
            'parent' => array(self::BELONGS_TO, 'Users_Files', 'parent_id'),
            'childs' => array(self::HAS_MANY, 'Users_Files', 'parent_id'),
        );
    }

    public function getDirectories($parent = false, $folder = '')
    {
        if (!$parent) {
            $parent = $this;
        }
        if ($parent->document_type == 'folder') {
            $folder = $parent->name . '/' . $folder;
        }

        if ($parent->parent_id) {
            $folder = $parent->getDirectories($parent->parent, $folder);
        }
        return $folder;

    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'User',
            'name' => 'Name',
            'ext' => 'Ext',
            'user_file_name' => 'user_file_name',
            'type' => 'Type',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('form', $this->form);
        $criteria->with = 'personal_document';
        $criteria->together = true;


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users_Files the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getShortDescription()
    {
        if (mb_strlen($this->description) > 30) {
            $str = SiteService::subStrEx(strip_tags(trim($this->description)), 30);
        } else {
            $str = strip_tags($this->description);
        }
        return $str;
    }
}
