<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
$this->title = '新增内容类型';
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-lg-5">
            </div>
        </div>
        <div class="row">

            <?php $form = ActiveForm::begin([]);?>
            <div class="col-xs-6">
                <?= $form->field($model, 'label')->textInput(['maxlength' => true])?>
                <?= $form->field($model, 'data_description')->textarea() ?>

                <div class="form-group">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
                </div>
            </div>
            <div class="col-xs-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <?php ActiveForm::end();?>
        </div>
    </div>
</div>
