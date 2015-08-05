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

class SettingController extends BaseController{
    public function actionIndex(){
        $nodeTypes = $this->getNodeTypes();
        return $this->render('index', [
            'nodeTypes' => $nodeTypes,
        ]);
    }
    public function getFieldList(){
        $fields = ViewModel::findAll(['collection'=>'']);
    }
    private function getNodeTypes(){
        $types = [];
        $results = ViewModel::findAll(['collection'=>'node.type']);
        if($results){
            foreach($results as $item){
                $types[$item->name] = $item->label;
            }
        }

        return $types;
    }
}