<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
$this->title = 'gis';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-5">

            </div>
        </div>
        <div class="row">

            <?php

             $form = ActiveForm::begin([
                'id' => 'node-form','options' => ['enctype' => 'multipart/form-data'],
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,

            ]); ?>
            <?= Html::activeHiddenInput($model,'nid'); ?>
            <?php foreach($model->getAttachedFields() as $fieldName => $attachedField): ?>
                <?= $this->render($attachedField->getViewPath(),['form'=>$form,'model'=>$attachedField,'fieldName'=>$fieldName]); ?>
            <?php endforeach ?>

            <div class="form-group">
                <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end();

            ?>
        </div>
    </div>
</div>
