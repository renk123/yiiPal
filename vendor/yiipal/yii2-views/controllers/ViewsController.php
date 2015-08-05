<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/24
 * Time: 11:16
 */

namespace yiipal\views\controllers;

use Yii;
use yiipal\base\controllers\BaseController;
use yiipal\views\models\ViewModel;

class ViewsController extends BaseController{
    public function actionIndex(){

    }

    public function actionCreate(){
        $model = new ViewModel();
        $model->collection  = 'views';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/views/views/update?name='.$model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($name){
        $model = $this->findModel($name);
        $model->collection  = 'views';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/views/views']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    protected function findModel($name)
    {
        $model = ViewModel::findOne(['collection'=>'views', 'name'=>$name]);
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}