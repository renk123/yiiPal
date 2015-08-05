<?php
namespace yiipal\cck\models\behaviors;

use common\models\BaseField;
use yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\behaviors;
use yiipal\base\controllers\BaseController;
use yiipal\base\models\BaseModel;
use yiipal\base\models\Config;

class AttachFieldsBehavior extends behaviors\AttributeBehavior
{

    const FIELD_PREFIX = 'field.node.';
    public $attachedFields = [];
    public $value;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    public function getAttachedFields(){
        return $this->attachedFields;
    }

    public function attachFields($event){
        $sender = $event->sender;
        $nodeFields = $this->getFieldsInfo($sender->type);
        foreach($nodeFields as $field){
            $this->attachedFields[$field->name] = new $field->data_field_class($field->data);
        }
    }

    public function getFieldsInfo($type, $fieldName = null){
        $cacheIndex = $type.'_'.$fieldName;
//        FIXME：等待清楚缓存模块做好后，开启缓存功能呢。
//        if($fieldsInfo = Yii::$app->cache->get($cacheIndex)){
//            return $fieldsInfo;
//        }
        $conditions = ['collection'=>self::FIELD_PREFIX.$type];
        if(isset($fieldName)){
            $conditions['name'] = $fieldName;
        }
        $fieldsInfo = Config::findAll($conditions);
        Yii::$app->cache->set($cacheIndex, $fieldsInfo);
        return $fieldsInfo;
    }

    public function __get($name)
    {
        if(array_key_exists($name, $this->attachedFields)){
            return $this->attachedFields[$name]->getValue();
        }
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if(array_key_exists($name, $this->attachedFields)){
            $fieldInstance = $this->attachedFields[$name];
            $fieldInstance->setValue($value);
            return;
        }else{
            parent::__set($name, $value);
        }
    }

    public function events()
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => 'validateExtraFields',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'saveExtraFields',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'saveExtraFields',
            BaseController::EVENT_YIIPAL_FIND_ONE_RECORD => 'findAttachedFields',
            ActiveRecord::EVENT_AFTER_FIND => 'collectFieldsAfterFind',
            BaseModel::EVENT_YIIPAL_EVENT_MODEL_INIT => 'attachFields',
        ];
    }

    public function canGetProperty($name, $checkVars = true)
    {
        return array_key_exists($name, $this->attachedFields) || parent::canGetProperty($name, $checkVars);
    }

    public function canSetProperty($name, $checkVars = true)
    {
        return array_key_exists($name, $this->attachedFields) || parent::canSetProperty($name, $checkVars);
    }

    public function validateExtraFields($event){
        foreach($this->attachedFields as $key => &$attachedField){
            $attachedField::$tableName = $key;
            $attachedField->load(\Yii::$app->request->post());
            if(!$attachedField->validate()){
                $this->owner->addError($key,$attachedField->getFirstError('value'));
            }
        }
    }

    public function saveExtraFields($event){
        $sender = $event->sender;
        foreach($this->attachedFields as $key => $attachedField){
            //FIXME:动态设定字段表名字
            $attachedField::$tableName = $key;
            $attachedField->setData($sender);
            $attachedField->save();
        }
    }

    public function getAttachedField($name){
        if(array_key_exists($name, $this->attachedFields)){
            return $this->attachedFields[$name];
        }
        return false;
    }

    public function findAttachedFields($event){
        $sender = $event->sender;
        foreach($this->attachedFields as $key => &$attachedField){
            $attachedField::$tableName = $key;
            $model = $attachedField::findOne(['nid'=>$sender->nid]);
            if (!empty($model)) {
                $attachedField = $model;
            }
        }
    }

    public function collectFieldsAfterFind($event){

        $sender = $event->sender;
        if(empty($this->attachedFields)){
            $this->attachFields($event);
        }
        foreach($this->attachedFields as $key => &$attachedField){
//            $raw['value'] = $event->sender->company;
//            $raw['bundle'] = $event->sender->company_bundle;
//            $attachedField->raw = $raw;
        }
    }

}
