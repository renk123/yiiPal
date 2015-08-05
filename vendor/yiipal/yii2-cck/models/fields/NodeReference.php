<?php

namespace yiipal\cck\models\fields;

use yii\db\Query;
use yiipal\cck\models\BaseField;
use Yii;

class NodeReference extends BaseField
{

    protected $viewPath = '@yiipal/cck/views/fields/nodereference/edit';
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
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'value' => isset($this->options['label'])?$this->options['label']:"选择",
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

    public function getOptions(){
        $output = [];
        self::$tableName = $this->options['reference_field'];
        $items = $this->findAll(['bundle'=>$this->options['reference_type']]);
        foreach($items as $item){
            $output[$item->nid] = $item->value;
        }
        return $output;
    }
}
