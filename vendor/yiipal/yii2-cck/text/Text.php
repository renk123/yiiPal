<?php

namespace yiipal\cck\text;

use yii\db\Query;
use yii\helpers\Url;
use yiipal\cck\models\BaseField;
use Yii;

class Text extends BaseField
{
    protected $viewPath = '@yiipal/cck/views/fields/text/edit';
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['value'], 'trim']
        ];

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

    public function getSettingUrl(){
        return Url::to(['/cck/fields/'.$this->data_type,'collection'=>$this->collection,'name' =>$this->name ]);
    }
}
