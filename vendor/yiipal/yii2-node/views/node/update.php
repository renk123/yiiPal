<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
            <div class="col-xs-6">
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
            <?php ActiveForm::end();?>
            </div>
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

            //$(".field-fieldmodel-name").hide();

        });'
);
?>