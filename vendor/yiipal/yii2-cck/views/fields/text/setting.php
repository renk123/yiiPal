<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
$this->title = '字段设置';
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-lg-5">
            </div>
        </div>
        <div class="row">
            <?php $form = ActiveForm::begin([]);?>
            <div class="col-xs-4">
                <?= $form->field($model, 'data_label')->textInput(['maxlength' => true])?>
                <?= $form->field($model, 'data_required')->checkbox()->label('必填项')?>
                <?= $form->field($model, 'data_maxlength')->textInput(['maxlength' => 2])->label('最大字符数')?>
                <?= $form->field($model, 'data_default_value')->textInput(['maxlength' => true])->label('默认值')?>
                <div class="form-group">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>
            <div class="col-xs-8">
            </div>
            <?php ActiveForm::end();?>
        </div>
    </div>
</div>