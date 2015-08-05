<?php

namespace yiipal\cck\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\validators\Validator;
use yiipal\base\models\Config;
use yiipal\cck\utils\CCKHelp;

/**
 * This is the model class for table "file".
 *
 * @property string $fid
 * @property string $tid
 * @property string $filename
 * @property string $uri
 * @property string $filemime
 * @property string $filesize
 * @property integer $status
 * @property integer $created
 * @property integer $changed
 */
class BaseField extends \yii\db\ActiveRecord
{
    const FIELD_TABLE_PREFIX = 'node_field_';
    protected $viewPath = '@yiipal/cck/views/fields/default';
    public $options = [];
    public $raw = [];
    static $tableName = '';
    public function __construct($options = [],$config = []){
        parent::__construct($config);
        $this->options = $options;
        if(isset($options['name'])){
            self::$tableName = $options['name'];
        }
        if(isset($options['default_value'])){
            $this->value = $options['default_value'];
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        if(!empty(self::$tableName)){
            return self::FIELD_TABLE_PREFIX.strtolower(self::$tableName);
        }else{
            self::FIELD_TABLE_PREFIX.strtolower(basename(self::className()));
        }
    }
    public function formName()
    {
        if(!empty(self::$tableName)){
            return ucfirst(self::$tableName);
        }else{
            parent::formName();
        }
    }

    public function getFieldName(){
        return strtolower(self::className());
    }

    public function getValue(){
        return $this->value;
    }

    public function getDisplayValue($data = null){
        return $this->value;
    }

    public function setValue($value){
        $this->value = $value;
    }
    public function setData($data){
        $this->__set('nid',$data->nid);
        $this->__set('bundle',$data->type);
    }

    public function getViewPath(){
        return $this->viewPath;
    }

    public function setViewPath($path){
        $this->viewPath = $path;
    }

    public function isEmpty(){
        return empty($this->value)?true:false;
    }

    public function createFieldTable($fieldName){
        $columns = CCKHelp::getColumnsInfo(basename(self::className()));
        $fieldName = self::FIELD_TABLE_PREFIX.strtolower($fieldName);
        $this->getDb()->createCommand()->createTable($fieldName, $columns)->execute();
    }
    public function addRule($attributes, $validator, $options = [])
    {
        $validators = $this->getValidators();
        $validators->append(Validator::createValidator($validator, $this, (array) $attributes, $options));
        return $this;
    }
}
