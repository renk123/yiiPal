<?php

namespace yiipal\base\models;

use Yii;

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
class File extends \yii\db\ActiveRecord
{
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
    public function rules()
    {
        return [
            [['tid', 'filesize', 'status', 'created', 'changed'], 'integer'],
            [['uri', 'status', 'changed'], 'required'],
            [['filename', 'uri', 'filemime'], 'string', 'max' => 255],
            [['uri'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fid' => 'Fid',
            'tid' => 'Tid',
            'filename' => 'Filename',
            'uri' => 'Uri',
            'filemime' => 'Filemime',
            'filesize' => 'Filesize',
            'status' => 'Status',
            'created' => 'Created',
            'changed' => 'Changed',
        ];
    }
}
