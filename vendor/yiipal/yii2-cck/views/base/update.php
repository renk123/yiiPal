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
<?php
    $this->registerJs(
        '$("document").ready(function(){
            $("#fieldmodel-data_existing_type").change(function(){
                $("#fieldmodel-data_type").val("");
                var patten = /.*\((.*)\)/;
                var label = $(this).find("option:selected").text().match(patten);
                $("#fieldmodel-data_label").val(label[1]);
                if($(this).val()){
                    $(".field-fieldmodel-name").hide();
                }
            });

            $("#fieldmodel-data_type").change(function(){
                if($(this).val()){
                    $("#fieldmodel-data_existing_type").val("");
                    $(".field-fieldmodel-name").show();
                }else{
                    $(".field-fieldmodel-name").hide();
                }
            });

            $(".field-fieldmodel-name").hide();

        });'
    );
?>