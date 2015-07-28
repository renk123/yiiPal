<?php
//FIXME:修改设定方法
$model::$tableName = $fieldName;
?>
<?= $form->field($model, 'value')->textInput() ?>