<?php
namespace yiipal\cck\models;

use Yii;
use yii\db\Migration;
use yiipal\base\models\Config;
use yiipal\base\models\BaseModel;

/**
 * Login form
 */
class TableModel extends BaseModel
{
    public $name;
    public $label;
    public $description;
    public $extraFields = [];
    private $defaultColumns = [
        'id'=>'pk',
        'status'=>'tinyint(1) NOT NULL',
        'created_at'=>'int(11) NOT NULL',
        'updated_at'=>'int(11) NOT NULL'];

    /**
     * @inheritdoc
     */
    public static function name()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'label'], 'required'],
            [['description'], 'trim'],
            ['name', 'match', 'pattern' => '/^[a-z]\w*$/i'],
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            return $this->insert($runValidation, $attributeNames);
        } else {
            return $this->update($runValidation, $attributeNames) !== false;
        }
    }

    public function insert($runValidation = true, $attributes = null)
    {
        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Table not created due to validation error.', __METHOD__);
            return false;
        }
        $op = new Migration();
        if($this->getDb()->getTableSchema($this->name)){
            $this->addError('name', '数据表已经存在！');
            return false;
        }
        try{
            $this->getDb()->createCommand()->createTable($this->name, $this->defaultColumns)->execute();
            $config = new Config();
            $config->collection = 'table';
            $config->name = $this->name;
            $data = new \StdClass;
            $data->description = $this->description;
            $config->data = serialize($data);
            $config->save();
            return true;
        }catch (\Exception $e){
            Yii::$app->session->addFlash('error','创建失败！');
            return false;
        }
    }

    public static function find(){
        return Config::find();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '数据表名',
        ];
    }

}
