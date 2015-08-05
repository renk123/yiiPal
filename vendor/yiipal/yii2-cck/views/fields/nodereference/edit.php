<?php
//FIXME:修改设定方法
$model::$tableName = $fieldName;
?>
<?= $form->field($model, 'value')->widget(\kartik\widgets\Select2::classname(), [
    'data' => $model->getOptions(),
    'language' => 'en',
    'options' => ['placeholder' => '选择'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]) ?>