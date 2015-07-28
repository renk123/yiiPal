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
        'body' => [
            'field_name' => 'body',
            'field_type' => 'body',
            'field_label' => '主内容',
            'field_description' => '用于描述等多内容输入区块',
            'field_class' => 'yiipal\cck\body\Body',
        ],
    ]
];