<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/19
 * Time: 11:06
 */

namespace yiipal\cck\controllers;

use yii\data\ActiveDataProvider;
use yiipal\base\controllers\BaseController;
use yiipal\base\models\Config;
use yiipal\cck\models\Schema;
use yiipal\cck\models\TableModel;

class SchemaController extends BaseController{

    public function actionIndex(){
        $model = new TableModel();
        $dataProvider = new ActiveDataProvider([
            'query' => TableModel::find(),
            'pagination' => [
                'pagesize' => '2',
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    /**
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TableModel();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->nid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
}