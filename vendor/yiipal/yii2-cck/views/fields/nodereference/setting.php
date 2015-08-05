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
                <?= $form->field($model, 'data_default_value')->textInput(['maxlength' => true])->label('默认值')?>
                <?= $form->field($model, 'data_reference_type')->radioList($nodeTypes)->label('关联内容类型')?>
                <?= $form->field($model, 'data_reference_field')->dropDownList([''=>'选择显示字段'])->label('关联内容显示字段')?>
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
    '
    $("document").ready(function(){
        $("#fieldmodel-data_reference_type input[type=radio]:checked").change(function(){
            var options = "<option>选择显示字段</option>";
            $.getJSON("nodereference/getnodefields?nodeType="+$(this).val(),function(data){
                $.each(data, function(index, item){
                    options += "<option value="+index+">"+item+"</option>";
                });
                $("#fieldmodel-data_reference_field").html(options).val("'.$model->data_reference_field.'");
            });
        }).change();
    });'
);
?>