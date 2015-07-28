<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
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

            <?= \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'nid',
                    'company',
                    'company'=>[
                        'class' => 'yii\grid\DataColumn',
                        'attribute'=> 'company',
                        'label' => '字段名',
                        'value' => function ($data) {
                            return $data->attachedFields['company']->raw['value'];
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'headerOptions' => ["width" => "80"],
                        'buttons' =>[
                            'update' => function ($url, $model, $key) {
                                $options = array_merge([
                                    'title' => Yii::t('yii', '编辑'),
                                    'aria-label' => Yii::t('yii', '编辑'),
                                    'data-pjax' => '0',
                                ]);
                                $url = Url::to(['/node/update/'.$model->type,'id' => $model->nid]);
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                            },
                            'delete' => function ($url, $model, $key) {
                                $options = array_merge([
                                    'title' => Yii::t('yii', '删除'),
                                    'aria-label' => Yii::t('yii', '删除'),
                                    'data-pjax' => '0',
                                ]);
                                $url = Url::to(['/node/delete/'.$model->type,'id' => $model->nid]);
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
