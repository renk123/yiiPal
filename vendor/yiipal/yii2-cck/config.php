<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/30
 * Time: 11:07
 */

return [
    'fieldsList' => [
        'text' => [
            'field_name' => 'text',
            'field_type' => 'text',
            'field_label' => '文本',
            'field_description' => '用于普通输入框',
            'field_class' => 'yiipal\cck\models\fields\Text',
            'setting_url' => '/cck/fields/text',
        ],
        'nodereference' => [
            'field_name' => 'NodeReference',
            'field_type' => 'nodereference',
            'field_label' => '关联内容',
            'field_description' => '关联其他类型的内容',
            'field_class' => 'yiipal\cck\models\fields\NodeReference',
            'setting_url' => '/cck/fields/nodereference',
        ],
        'body' => [
            'field_name' => 'body',
            'field_type' => 'body',
            'field_label' => '主内容',
            'field_description' => '用于描述等多内容输入区块',
            'field_class' => 'yiipal\cck\body\Body',
        ],
    ]
];