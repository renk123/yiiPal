<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
$this->title = '字段管理';
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-xs-6">
                <div class="btn-group">
                    <p>
                        <?= Html::a('新增', ['create','type'=>$type], ['class' => 'btn btn-success']) ?>
                    </p>
                </div>
            </div>
            <div class="col-xs-6">
                <ul class="nav nav-tabs nav-justified pull-right" style="width: 300px;">
                    <li role="presentation" class="active"><a href="#">字段设置</a></li>
                    <li role="presentation"><a href="#">视图配置</a></li>
                    <li role="presentation"><a href="#">显示配置</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{items}{pager}{summary}',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => '字段名',
                        'value' => function ($data) {
                            return $data->data_label;
                        },
                    ],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => '字段名（系统）',
                        'value' => function ($data) {
                            return $data->name;
                        },
                    ],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => '字段类型',
                        'value' => function ($data) {
                            return isset($data->data["field_label"])?$data->data["field_label"]:'';
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{config} {update} {delete}',
                        'headerOptions' => ["width" => "80"],
                        'buttons' =>[
                            'config' => function ($url, $model, $key) {
                                $options = array_merge([
                                    'title' => Yii::t('yii', '设置字段'),
                                    'aria-label' => Yii::t('yii', '设置字段'),
                                    'data-pjax' => '0',
                                ]);
                                //$url = Url::to(['/cck/fields/'.$model->data_type,'collection'=>$model->collection,'name' =>$model->name]);
                                $url = Url::to([$model->data_setting_url,'collection'=>$model->collection,'name' =>$model->name ]);
                                return Html::a('<span class="glyphicon glyphicon-cog"></span>', $url, $options);
                            }
                        ]
                    ],
                ],
            ]); ?>
            </div>
        </div>
    </div>
</div>
