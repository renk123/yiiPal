<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yiipal\cck\CckAsset;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 */
$this->title = 'asdf';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>