<?php

namespace yiipal\cck\models\fields;

use yii\behaviors\TimestampBehavior;
use Yii;
use yii\web\UploadedFile;
use yiipal\cck\models\BaseField;

/**
 * This is the model class for table "file".
 *
 * @property string $fid
 * @property string $tid
 * @property string $filename
 * @property string $uri
 * @property string $filemime
 * @property string $filesize
 * @property integer $status
 * @property integer $created
 * @property integer $changed
 */
class File extends BaseField
{

    const UPLOAD_PATH = 'uploads/';
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['uri'], 'file', 'checkExtensionByMimeType' => true, 'extensions' => 'gif, jpg', 'maxFiles' => 10],
        ];

    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if(empty($this->filename)){
            return;
        }
        $this->uri = self::UPLOAD_PATH . $this->file->baseName . '.' . $this->file->extension;
        $this->file->saveAs($this->uri);
        parent::save($runValidation, $attributeNames);
    }

    public function setValue($file){
        if(empty($file)){
            return ;
        }

        $this->file = $file;
        $this->filename = $this->file->baseName . '.' . $this->file->extension;
        $this->__set('filemime',$file->type);
        $this->__set('filesize',$file->size);
    }

    public function setData($data){
        $this->__set('nid',$data->nid);
    }

    public function getValue(){
        return $this->uri;
    }

    public function getViewPath(){
        return '@yiipal/cck/views/fields/file';
    }

    public function load($data, $formName = null)
    {
        $scope = $formName === null ? $this->formName() : $formName;
        $file = UploadedFile::getInstance($this, 'uri');
        if(!empty($file)){
            $this->file = $file;
            $data = [
                        'filename'=> $this->file->baseName . '.' . $this->file->extension,
                        'filesize'=> $file->size,
                        'filemime'=> $file->type
                    ];
            $this->setAttributes($data, false);
        }else{
            $this->filename = null;
            return false;
        }
    }
}
