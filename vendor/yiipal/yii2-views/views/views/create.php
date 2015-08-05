<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;
/* @var $this yii\web\View */
$this->title = '创建视图';
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php $form = ActiveForm::begin(['id'=>'create_view']);?>
                            <?=$form->field($model, 'name')->textInput() ?>
                            <?=$form->field($model, 'label')->textInput() ?>
                            <?=$form->field($model, 'data_description')->textarea() ?>
                            <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
                        <?php ActiveForm::end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    $this->registerJs(
        ''
    );
?>