<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/24
 * Time: 11:16
 */

namespace yiipal\system\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yiipal\base\controllers\BaseController;
use yiipal\base\models\Config;
use yiipal\base\utils\BaseHelp;
use yiipal\cck\models\FieldModel;

class ContenttypeController extends BaseController{
    public function actionIndex(){
        $query = Config::find();
        $query->andFilterWhere(['=', 'collection', 'node.type']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Config(['scenario'=>'uniqueName']);
        $model->collection  = 'node.type';//.BaseHelp::post($model,'name');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($name)
    {
        $model = $this->findModel($name);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($name)
    {
        $model = $this->findModel($name)->delete();
        $fields = FieldModel::findAll(['collection'=>"field.node.$name"]);
        foreach($fields as $field){
            $field->delete();
        }
        return $this->redirect(['index']);
    }

    public function actionConfig($name)
    {
        $str = 'a:16:{s:4:"uuid";s:36:"1d055193-983a-4a5a-ad00-d7886f6cd387";s:8:"langcode";s:2:"en";s:6:"status";b:1;s:12:"dependencies";a:2:{s:6:"config";a:2:{i:0;s:23:"field.storage.node.body";i:1;s:17:"node.type.article";}s:6:"module";a:1:{i:0;s:4:"text";}}s:2:"id";s:17:"node.article.body";s:10:"field_name";s:4:"body";s:11:"entity_type";s:4:"node";s:6:"bundle";s:7:"article";s:5:"label";s:4:"Body";s:11:"description";s:0:"";s:8:"required";b:0;s:12:"translatable";b:1;s:13:"default_value";a:0:{}s:22:"default_value_callback";s:0:"";s:8:"settings";a:1:{s:15:"display_summary";b:1;}s:10:"field_type";s:17:"text_with_summary";}';
        $str = 'a:15:{s:4:"uuid";s:36:"4140c962-5e9d-4ef4-9b24-36871bbf6371";s:8:"langcode";s:2:"en";s:6:"status";b:1;s:12:"dependencies";a:1:{s:6:"module";a:2:{i:0;s:4:"node";i:1;s:4:"text";}}s:2:"id";s:9:"node.body";s:10:"field_name";s:4:"body";s:11:"entity_type";s:4:"node";s:4:"type";s:17:"text_with_summary";s:8:"settings";a:0:{}s:6:"module";s:4:"text";s:6:"locked";b:0;s:11:"cardinality";i:1;s:12:"translatable";b:1;s:7:"indexes";a:0:{}s:22:"persist_with_no_fields";b:1;}';
        $str = unserialize($str);
        print_r($str);exit;
        $this->findModel($name)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($name)
    {
        $model = Config::findOne(['collection'=>'node.type', 'name'=>$name]);
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}