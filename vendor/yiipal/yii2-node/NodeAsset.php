<?php

namespace yiipal\node;


class NodeAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@yiipal/cck/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'main.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'yii.admin.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
