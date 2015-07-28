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
use yiipal\cck\models\BaseField;
use yiipal\cck\models\FieldModel;
use yiipal\cck\utils\CCKHelp;

class ContentfieldsController extends BaseController{
    public function actionIndex($type){
        $query = FieldModel::find();
        $query->andFilterWhere(['=', 'collection', 'field.node.'.$type]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'type' => $type
        ]);
    }

    public function actionCreate($type)
    {
        $fieldsOptions = CCKHelp::getCCKOptions();
        $model = new FieldModel(['scenario' => 'create']);
        $availableFieldsInfo = $model->getAvailableFieldsInfo($type);
        $model->setAttributeLabels(['name'=>'字段名（系统）']);
        $model->setAttributeLabels(['data_type'=>'新增字段']);
        $model->setAttributeLabels(['data_existing_type'=>'选择已有字段']);
        $model->collection  = 'field.node.'.$type;
        $post = Yii::$app->request->post();

        if(!empty($post['FieldModel']['data_type'])){
            $cckOptions = CCKHelp::getCCKOptionData($post['FieldModel']['data_type']);
            $cckOptions['label'] = $post['FieldModel']['data_label'];
            $cckOptions['type'] = $post['FieldModel']['data_type'];
            $cckOptions['name'] = $post['FieldModel']['name'];
            $model->data = $cckOptions;
        }

        if(!empty($post['FieldModel']['data_existing_type'])){
            $fieldType = $availableFieldsInfo['data'][$post['FieldModel']['data_existing_type']]->data_type;
            $cckOptions = CCKHelp::getCCKOptionData($fieldType);
            $cckOptions['label'] = $post['FieldModel']['data_label'];
            $cckOptions['field_type'] = $cckOptions['field_type'];
            $cckOptions['name'] = $post['FieldModel']['data_existing_type'];
            $post['FieldModel']['name'] = $post['FieldModel']['data_existing_type'];
            $model->data = $cckOptions;
        }

        if ($model->load($post) && $model->save()) {
            if(empty($post['FieldModel']['data_existing_type'])){
                $field = unserialize($model->data);
                $fieldInstance = new $field['field_class']();
                $fieldInstance->createFieldTable($model->name);
            }
            return $this->redirect(['index','type'=>$type]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'fieldsOptions'=>$fieldsOptions,
                'availableFieldsOptions'=>$availableFieldsInfo['options'],
            ]);
        }
    }

    public function actionUpdate($name, $collection)
    {
        $fieldsOptions = CCKHelp::getCCKOptions();
        $model = $this->findModel($name, $collection);
        $model->scenario = 'update';
        $post = Yii::$app->request->post();
        if(isset($post['FieldModel']['data_type'])){
            $cckOptions = CCKHelp::getCCKOptionData($post['FieldModel']['data_type']);
            $model->data = $cckOptions;
            $model->data_type = $post['FieldModel']['data_type'];
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //FIXME: 修正此处的类型获取方法
            return $this->redirect(['index','type'=>str_replace('field.node.','', $collection)]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'fieldsOptions'=>$fieldsOptions,
            ]);
        }
    }

    public function actionDelete($name, $collection)
    {
        $model = $this->findModel($name, $collection);
        $model->delete();
        return $this->redirect(['index','type'=>str_replace('field.node.','', $collection)]);
    }

    protected function findModel($name, $collection)
    {
        $model = FieldModel::findOne(['name'=>$name, 'collection' => $collection]);
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}