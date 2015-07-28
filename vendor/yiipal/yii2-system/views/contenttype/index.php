<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
$this->title = '内容类型';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-xs-12">
                <div class="btn-group">
                    <p>
                        <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                </div>
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
                        'label' => '内容类型',
                        'value' => function ($data) {
                            return $data->label;
                        },
                    ],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => '描述',
                        //'format' => 'html',
                        'value' => function ($data) {
                            //$data = unserialize($data->data);
                            return isset($data["data_description"])?$data["data_description"]:'';
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{config} {update2} {delete}',
                        'headerOptions' => ["width" => "80"],
                        'buttons' =>[
                            'config' => function ($url, $model, $key) {
                                $options = array_merge([
                                    'title' => Yii::t('yii', '管理字段'),
                                    'aria-label' => Yii::t('yii', '管理字段'),
                                    'data-pjax' => '0',
                                ]);
                                $url = Url::to(['/system/contentfields/index','type' => $model->name]);
                                return Html::a('<span class="glyphicon glyphicon-cog"></span>', $url, $options);
                            },
                        ]
                    ],
                ],
            ]); ?>
            </div>
        </div>
    </div>
</div>
