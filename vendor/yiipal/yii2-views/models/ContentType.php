<?php
namespace yiipal\system\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yiipal\base\models\BaseModel;
use yiipal\cck\models\behaviors\AttachFieldsBehavior;
use yiipal\cck\models\fields\Text;

class ContentType extends BaseModel
{
    public $type = 'model';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        Yii::$container->set('text', 'yiipal\cck\models\fields\Text');
        return [
            [
                'class' => AttachFieldsBehavior::className(),
                'attachedFields' => [
                    'name' => new Text(['label'=>'模型名称（英文）']),
                    'label' => new Text(['label'=>'中文名']),
                    'nickname' => Yii::$container->get('text',['label'=>'测试名字'])
                ],

            ],
        ];
    }
}
