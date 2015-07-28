<?php
/**
 * Created by yiiPal.
 * User: Steven.R(Renkuan)
 * QQ:359876077
 * Date: 2015/7/7
 * Time: 10:31
 */

namespace yiipal\base\utils;


use yii\base\Model;

class BaseHelp {
    public static function arg($index = NULL, $path = NULL){
        $args = [];
        if (isset($path)) {
            $param = $path;
        }else{
            $param = \Yii::$app->getRequest()->get('param');
        }
        if(!empty($param)){
            $args = explode('/', $param);
        }
        if (!isset($index)) {
            return $args;
        }
        if (isset($args[$index])) {
            return $args[$index];
        }
    }

    public static function post(Model $model, $name){
        $post = \Yii::$app->request->post();
        return $post[$model->formName()]['name']?:null;
    }
}