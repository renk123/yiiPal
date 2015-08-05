<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
$this->title = '';
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">

            <div class="col-xs-4">
                <div style="min-width: 120px;max-width: 200px;">
                    <?= Html::ul($nodeTypes, ["class"=>"list-group","item"=>function($item, $index){return '<a href="/views/setting/getFields?nodeType='.$index.'" class="list-group-item ajax"><span class="glyphicon glyphicon-list-alt"></span> '.$item.'</a>';},"itemOptions"=>["class"=>"list-group-item"]]) ?>
                </div>
            </div>
            <div class="col-xs-8">
                <ul class="horizontal-list">
                    <li></li>
                </ul>
            </div>

        </div>

    </div>
</div>
