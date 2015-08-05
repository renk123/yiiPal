<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/19
 * Time: 11:06
 */

namespace yiipal\cck\controllers\fields;

use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yiipal\base\models\Config;
use yiipal\cck\controllers\BaseController;
use yiipal\cck\models\Schema;
use yiipal\cck\models\TableModel;

class NodereferenceController extends BaseController{

    public function actionIndex($name=null, $collection=null)
    {
        $model = $this->findModel($name, $collection);
        $model->setAttributeLabels(['data_reference_nid'=>'关联内容类型']);
        $model->setAttributeLabels(['data_reference_field'=>'关联内容字段']);
        $model->addRule('data_label','required');
        $model->addRule('data_reference_type','required');
        $model->addRule('data_reference_field','required');
        $nodeTypes = $this->getNodeTypes();
        $this->setAttributeToSafe($model);
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/system/contentfields/index','type'=>str_replace('field.node.','', $collection)]);
        } else {
            return $this->render('setting', [
                'model' => $model,
                'nodeTypes' => $nodeTypes,
            ]);
        }
    }

    private function getNodeTypes(){
        $nodes = Config::findAll(['collection'=>'node.type']);
        if(empty($nodes)){
            return [];
        }
        $types = [];
        foreach($nodes as $node){
            $types[$node->name] = $node->label;
        }
        return $types;
    }

    public function actionGetnodefields($nodeType){
        $output = [];
        $fields = Config::findAll(['collection'=>'field.node.'.$nodeType]);
        foreach($fields as $field){
            $output[$field->name] = $field->data_label;
        }
        echo Json::encode($output);exit;
    }
 }