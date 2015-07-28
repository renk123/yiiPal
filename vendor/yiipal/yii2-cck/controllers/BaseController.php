<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/19
 * Time: 11:06
 */

namespace yiipal\cck\controllers;

use yii\base\Controller;
use yiipal\cck\models\FieldModel;
use yiipal\base\controllers\BaseController as GbController;

class BaseController extends GbController{

    public function actionIndex($name=null, $collection=null){
        $model = $this->findModel($name, $collection);
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/system/contentfields/index','type'=>str_replace('field.node.','', $collection)]);
        } else {
            return $this->render('@yiipal/cck/views/base/update', [
                'model' => $model,
            ]);
        }
    }
    protected function findModel($name, $collection)
    {
        $model = FieldModel::findOne(['name'=>$name, 'collection' => $collection]);
        $model->scenario = 'update';
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function setAttributeToSafe(&$model){
        $post = \Yii::$app->request->post();
        $modelName = basename($model->className());
        if(!isset($post[$modelName])){
            return false;
        }
        $model->addRule(array_keys($post[$modelName]), 'safe');
        return $model;
    }
}