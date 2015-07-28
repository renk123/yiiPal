<?php
namespace yiipal\node\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yiipal\base\models\BaseModel;
use yiipal\base\models\Config;
use yiipal\cck\models\BaseField;
use yiipal\cck\models\behaviors\AttachFieldsBehavior;
use yiipal\cck\controllers\fields\BodyController;
use yiipal\cck\models\FieldModel;
use yiipal\cck\models\fields\Body;
use yiipal\cck\models\fields\File;

class Node extends BaseModel
{
    public $nodeType = 'article';
    public function __construct($type = '',$config = []){
        parent::__construct($config);
        if(!empty($type)){
            $this->type = $type;
            $this->nodeType = $type;
            $this->trigger(BaseModel::EVENT_YIIPAL_EVENT_MODEL_INIT);
        }
    }

    public function init(){
        parent::init();
    }

    public static function findQuery($nodeType)
    {
        $query = parent::find()->select(['node.*']);
        self::attachFieldsToQuery($query, $nodeType);
        return $query;
    }

    private function attachFieldsToQuery(&$query, $nodeType){
        $fields = FieldModel::getNodeFields($nodeType);
        foreach($fields as $field){
            $fieldInstance = new $field->data_field_class($field->data);
            $query = $fieldInstance->alterQuery($query);
        }
        return $query;
    }

    public function attributes()
    {
        $attributes = array_keys(static::getTableSchema()->columns);
        $fields = FieldModel::getNodeFields($this->session->get('nodeType'));
        foreach($fields as $field){
            $fieldInstance = new $field->data_field_class($field->data);
            $attributes = $fieldInstance->alterAttributes($attributes);
        }
        return $attributes;
    }
}
