<?php

namespace yiipal\cck\models\fields;

use yiipal\cck\models\BaseField;
use Yii;

class Body extends BaseField
{
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
}
