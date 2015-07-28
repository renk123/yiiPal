<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/19
 * Time: 14:16
 */

namespace yiipal\cck\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\db\Schema as YiiSchema;
use yii\db\Migration;
use yii\helpers\ArrayHelper;
use yii\validators\Validator;
use yiipal\base\models\BaseModel;
use yiipal\base\models\Config;
use yiipal\cck\models\behaviors\AttachDataFieldBehavior;

class FieldModel extends ActiveRecord{

    private $_attributeLabels = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "Config";
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            AttachDataFieldBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['name','data_type'], 'required','on'=>'create', 'when' => function($model) {
                return empty($model->data_existing_type);
            },'whenClient' => "function (attribute, value) {
                return $('#fieldmodel-data_existing_type').val() == '';
            }"],
            ['data_label', 'required','on'=>'create'],
            ['name', 'match', 'pattern' => '/^[a-z][a-z0-9]*$/i','on'=>'create'],
            ['name', 'validateUniqueName','on'=>'create'],
            [['data_description', 'data_existing_type'], 'safe','on'=>'create'],
            ['data_label', 'required', 'on'=>'update'],
        ];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $default = [
            'data_label' => '名称',
            'name' => '名称（系统）',
            'data_description' => '描述',
        ];
        return ArrayHelper::merge($default, $this->_attributeLabels);
    }

    public function setAttributeLabels($attributeLabels = []){
        $this->_attributeLabels = $attributeLabels;
    }

    /**
     * check name is unique for the same collection.
     * @param $attribute
     * @param $params
     */
    public function validateUniqueName($attribute, $params)
    {
        $result = Config::findOne(['collection'=>$this->collection, 'name'=>$this->$attribute]);
        if($result){
            $this->addError($attribute, '字段名已经存在！');
        }
    }

    public function getAvailableFieldsInfo($nodeType){
        //FIXME: 修复此处获取可用字段的方法。
        $results = FieldModel::find()->where(['and',['like', 'collection','field.node%', false],
            ['NOT IN','name', (new Query())->select('name')->from('config')->where(['collection' => "field.node.$nodeType"])]])->all();
        $fieldInfo = $data = [];
        $options = [''=> '选择一个已存在的字段'];
        foreach($results as $item){
            $options[$item->name] = $item->data_type.': field_'.$item->name.'('.$item->data_label.')';
            $data[$item->name] = $item;
        }
        $fieldInfo['options'] = $options;
        $fieldInfo['data'] = $data;
        return $fieldInfo;
    }

    public function addRule($attributes, $validator, $options = [])
    {
        $validators = $this->getValidators();
        $validators->append(Validator::createValidator($validator, $this, (array) $attributes, $options));
        return $this;
    }

    public function delete()
    {
        $fieldName = $this->name;
        parent::delete();
        $this->dropFieldTableAfterDelete($fieldName);
    }

    public function dropFieldTableAfterDelete($fieldName){
        if(!$this->checkFieldExist($fieldName)){
            $tableName = BaseField::FIELD_TABLE_PREFIX.$fieldName;
            self::getDb()->createCommand()->dropTable($tableName)->execute();
        }
    }

    protected function checkFieldExist($fieldName){
        $model = self::findOne(['name'=>$fieldName]);
        if ($model !== null) {
            return $model;
        } else {
            return false;
        }
    }

    public static function getNodeFields($nodeType){
        static $fields;
        if(!isset($fields)){
            $fields = self::findAll(['collection'=>'field.node.'.$nodeType]);
        }
        return $fields;
    }
}