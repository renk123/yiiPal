<?php

namespace yiipal\base;

class BaseAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@yiipal/base/assets';

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
        'vendor/domready/ready.min.js',
        'yiipal.js',
        'ajax.js',
        'modal.js',
        'base.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
