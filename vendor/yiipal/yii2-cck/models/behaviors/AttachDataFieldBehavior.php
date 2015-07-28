<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yiipal\cck\models\behaviors;

use common\models\BaseField;
use yii\base\Controller;
use yii\base\Exception;
use yii\base\Model;
use yii\base\UnknownPropertyException;
use yii\base\View;
use yii\base\ViewEvent;
use yii\bootstrap\Modal;
use yii\db\BaseActiveRecord;
use yii\db\Expression;
use yii\base\Behavior;
use yii\base\Event;
use yii\behaviors;
use yii\debug\components\search\matchers\Base;
use yii\web\UploadedFile;
use yiipal\base\controllers\BaseController;

class AttachDataFieldBehavior extends behaviors\AttributeBehavior
{

    public function __get($name)
    {
        if($dataName = $this->getSerializeFieldName($name)){
            if(isset($this->owner->data[$dataName])){
                return $this->owner->data[$dataName];
            }else{
                return '';
            }
        }else{
            return parent::__get($name);
        }
    }

    public function __set($name, $value)
    {
        if($dataName = $this->getSerializeFieldName($name)){
            if(is_array($this->owner->data)){
                $data = $this->owner->data;
                $data[$dataName] = $value;
                $this->owner->data = $data;
            }elseif($name == 'data'){
                $this->owner->data = serialize($value);
            }else{
                $this->owner->data = [$name => $value];
            }
        }else{
            parent::__set($name, $value);
        }
    }

    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_FIND => 'unserializeDataField',
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'serializeDataField',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'serializeDataField',
        ];
    }

    public function canGetProperty($name, $checkVars = true)
    {
        return $this->checkSerializeField($name) || parent::canGetProperty($name, $checkVars);
    }

    public function canSetProperty($name, $checkVars = true)
    {
        return $this->checkSerializeField($name) || parent::canSetProperty($name, $checkVars);
    }

     public function unserializeDataField($event){
        $this->owner->data = unserialize($this->owner->data);
     }
    public function serializeDataField($event){
        $this->owner->data = serialize($this->owner->data);
    }

    private function checkSerializeField($name){
        return preg_match('/^data_.*/', $name);
    }

    private function getSerializeFieldName($name){
        preg_match('/^data_(.*)/', $name, $matches);
        return $matches?$matches[1]:'';
    }
}
