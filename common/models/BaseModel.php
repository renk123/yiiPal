<?php
namespace common\models;

use common\models\behaviors\AttachFieldsBehavior;
use Yii;
use yii\base\ModelEvent;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\db\BaseActiveRecord;
use yii\web\IdentityInterface;
use common\models\fields\File;
use common\models\fields\Body;
use yii\web\UploadedFile;



class BaseModel extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    public $type = '';
    private $extraFields = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%node}}';
    }

    public function __construct($config = []){
        parent::__construct($config);
        $this->on(Model::EVENT_BEFORE_VALIDATE, 'validateExtraFiled');
        $this->on(BaseActiveRecord::EVENT_AFTER_INSERT, 'saveExtraFiled');
    }

    /**
     * PHP getter magic method.
     * This method is overridden so that attributes and related objects can be accessed like properties.
     *
     * @param string $name property name
     * @throws \yii\base\InvalidParamException if relation name is wrong
     * @return mixed property value
     * @see getAttribute()
     */
    public function __get($name)
    {
        if(array_key_exists($name, $this->extraFields)){
            return $this->extraFields[$name]->getValue();
        }
        return parent::__get($name);
    }

    /**
     * PHP setter magic method.
     * This method is overridden so that AR attributes can be accessed like properties.
     * @param string $name property name
     * @param mixed $value property value
     */
    public function __set($name, $value)
    {
        if(array_key_exists($name, $this->extraFields)){
            $fieldInstance = $this->extraFields[$name];
            if($fieldInstance instanceof File){
                $value = UploadedFile::getInstance($this->owner, 'file');
            }
            $fieldInstance->setValue($value);
            return;
        }else{
            parent::__set($name, $value);
        }
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
//            [
//                'class' => AttachFieldsBehavior::className(),
//                'extraFields' => [
//                    'body'=>new Body(),
//                    'file' => new File(),
//                ],
//
//            ],
        ];
    }

    public function addFields(array $fields){
        $this->extraFields = array_merge($this->extraFields, $fields);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function events()
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => 'validateExtraFiled',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'saveExtraFiled',
        ];
    }



    public function validateExtraFiled($event){
        foreach($this->extraFields as $key => $extraField){
            if(!$extraField->validate()){
                $this->owner->addError($key,$extraField->getFirstError('value'));
            }
        }
    }

    public function saveExtraFiled($event){
        $sender = $event->sender;
        foreach($this->extraFields as $key => $extraField){
            $sender->value = $sender->$key;
            $extraField->setValues($sender);
            $extraField->save();
        }
    }
}
