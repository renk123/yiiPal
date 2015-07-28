<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\File */

$this->title = $model->isNewRecord?'创建表':'修改表';
$this->params['breadcrumbs'][] = ['label' => '表管理', 'url' => ['index']];
$this->params['breadcrumbs'][] =$model->getLabel('创建','更新');
?>
<div class="file-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>