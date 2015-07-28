<?php
/**
 * Created by yiiPal.
 * User: Steven.R(Renkuan)
 * QQ:359876077
 * Date: 2015/6/30
 * Time: 14:23
 */

namespace yiipal\cck\utils;

use Yii;
use yii\helpers\ArrayHelper;

class CCKHelp {
    public static function getCCKOptions(){
        $fieldsOptions = Yii::$app->params['fieldsList'];
        //print_r($fieldsOptions);exit;
        $options = [''=>'选择一个字段'];
        foreach($fieldsOptions as $key => $field){
            $options[$key] = $field['field_label'];
        }
        return $options;
    }
    public static function getCCKOptionData($name){
        $fieldsOptions = Yii::$app->params['fieldsList'];
        if(isset($fieldsOptions[$name])){
            return $fieldsOptions[$name];
        }else{
            return '';
        }
    }

    public static function getColumnsInfo($fieldName){
        if(!isset($fieldName)) return false;
        $dirPath = __DIR__ . "/../models/schema/";
        $filePath = $dirPath.strtolower($fieldName).".php";
        if(file_exists($filePath)){
            $columns = ArrayHelper::merge(
                require($dirPath."default.php"),
                require($filePath)
            );
        }else{
            $columns = require($dirPath."default.php");
        }
        return $columns;
    }
}