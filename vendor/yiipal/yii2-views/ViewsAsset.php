<?php

namespace yiipal\views;

class ViewsAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@yiipal/views/assets';

    /**
     * @inheritdoc
     */
    public $css = [

    ];

    /**
     * @inheritdoc
     */
    public $js = [

    ];

    public $depends = [
        'yiipal\base\BaseAsset',
    ];
}
