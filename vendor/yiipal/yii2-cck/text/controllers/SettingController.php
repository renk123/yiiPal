<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/19
 * Time: 11:06
 */

namespace yiipal\cck\text\controllers;

use yii\data\ActiveDataProvider;
use yiipal\base\models\Config;
use yiipal\cck\controllers\BaseController;
use yiipal\cck\models\Schema;
use yiipal\cck\models\TableModel;

class SettingController extends BaseController{

    public function actionIndex()
    {echo 123;exit;
        $model = new FieldModel();
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->nid]);
        } else {
            return $this->render('@yiipal/cck/views/node/update', [
                'model' => $model,
            ]);
        }
    }
 }