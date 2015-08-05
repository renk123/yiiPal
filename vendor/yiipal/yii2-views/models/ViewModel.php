<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/19
 * Time: 14:16
 */

namespace yiipal\views\models;

use Yii;
use yii\base\DynamicModel;
use yii\db\ActiveRecord;
use yii\db\Schema as YiiSchema;
use yii\db\Migration;
use yii\helpers\ArrayHelper;
use yii\validators\Validator;
use yiipal\base\models\BaseModel;
use yiipal\cck\models\behaviors\AttachDataFieldBehavior;

class ViewModel extends ActiveRecord{

    private $_attributeLabels = [];
    public $collection = 'views';

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
            [['name','label'], 'required'],
            ['name', 'match', 'pattern' => '/^[a-z][a-z0-9]*$/i'],
            ['name', 'validateUniqueName'],
            [['data'], 'safe'],
            [['data_description'], 'safe'],
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
            'label' => '名称',
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
        $result = ViewModel::findOne(['collection'=>$this->collection, 'name'=>$this->$attribute]);
        if($result){
            $this->addError($attribute, '名称（系统）已经存在！');
        }
    }

    public function addRule($attributes, $validator, $options = [])
    {
        $validators = $this->getValidators();
        $validators->append(Validator::createValidator($validator, $this, (array) $attributes, $options));
        return $this;
    }
}