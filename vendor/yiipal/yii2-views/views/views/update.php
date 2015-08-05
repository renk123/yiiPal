<?php
use yii\bootstrap\ActiveForm;
use yiipal\views\ViewsAsset;
ViewsAsset::register($this);

/* @var $this yii\web\View */
$this->title = '视图配置';
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-lg-5">
            </div>
        </div>
        <div class="row">
                <?php $form = ActiveForm::begin([]);?>
                <div class="panel panel-default">
                    <div class="panel-heading">视图配置</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <!--  字段配置block 开始  -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">字段配置  <span class="right"><a class="btn btn-default btn-xs ajax-modal" href="/views/setting?viewName=<?= $model->name ?>" modal-title="视图设置">添加</a></span></div>
                                    <div class="panel-body">
                                        <div class="nestable-lists">
                                            <div class="dd" id="nestable">
                                                <ol class="dd-list">
                                                    <li class="dd-item">

                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--  字段配置block 结束  -->
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">Panel footer</div>
                </div>
                <?php ActiveForm::end();?>
        </div>
    </div>
</div>
<?php
    $this->registerJs(
        '$("document").ready(function(){
        });'
    );
?>