<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class BaseForm extends Model
{
    public $title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // title is always required
            ['title', 'required'],
        ];
    }
}
