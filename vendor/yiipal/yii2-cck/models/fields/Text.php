<?php

namespace yiipal\cck\models\fields;

use yiipal\cck\models\BaseField;
use Yii;

class Text extends BaseField
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = $this->createRules();
        return $rules;
    }

    public function createRules(){
        $rules[] = ['value', 'trim'];
        if($this->options['required'] == 1){
            $rules[] = ['value', 'required'];
        }
        if($this->options['maxlength']>1){
            $rules[] = ['value', 'string', 'max'=>intval($this->options['maxlength'])];
        }
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'value' => isset($this->options['label'])?$this->options['label']:"文本",
        ];
    }

    public function getDisplayValue($data = null){
        return $data['value']?:'';
    }

    public function alterQuery(&$query){
        $tableName = BaseField::FIELD_TABLE_PREFIX.$this->options['name'];
        $columns = $this->getQueryFields();
        $query->addSelect($columns);
        $query->leftJoin($tableName, "$tableName.nid=node.nid");
        return $query;
    }

    public function getQueryFields(){
        $tableName = BaseField::FIELD_TABLE_PREFIX.$this->options['name'];
        $columns[] = $tableName.".value as ".$this->options['name'];
        $columns[] = $tableName.".bundle as ".$this->options['name']."_bundle";
        return $columns;
    }

    public function alterAttributes(&$attributes){
        $attributes[] = $this->options['name'];
        $attributes[] = $this->options['name']."_bundle";
        return $attributes;
    }
}
