<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/19
 * Time: 11:06
 */

namespace yiipal\cck\controllers\fields;

use yii\data\ActiveDataProvider;
use yiipal\base\models\Config;
use yiipal\cck\controllers\BaseController;
use yiipal\cck\models\Schema;
use yiipal\cck\models\TableModel;

class TextController extends BaseController{

    public function actionIndex($name=null, $collection=null)
    {
        $model = $this->findModel($name, $collection);
        $this->setAttributeToSafe($model);
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/system/contentfields/index','type'=>str_replace('field.node.','', $collection)]);
        } else {
            return $this->render('setting', [
                'model' => $model,
            ]);
        }
    }
 }