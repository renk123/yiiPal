<?php
namespace yiipal\base\models;


use Yii;
use yii\base\ModelEvent;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\db\BaseActiveRecord;
use yii\db\QueryBuilder;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\db\Query;
use yiipal\cck\models\behaviors\AttachFieldsBehavior;


class BaseModel extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const QUERY_LIMITED = 10;
    const STATUS_ACTIVE = 1;
    const EVENT_YIIPAL_EVENT_MODEL_INIT = 'event_yiipal_event_model_init';


    public $status = self::STATUS_ACTIVE;
    protected $query = null;
    protected $session;
    public $nodeType = 'article';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'node';
    }

    public function __construct($config = []){
        $this->session = Yii::$app->session;
        parent::__construct($config);
    }

    public function init(){
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => AttachFieldsBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nid'], 'safe'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['type', 'default', 'value' => $this->type],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function getConfig($collection, $name = null, $offset = 0, $limit = self::QUERY_LIMITED){
        $query = $this->query->select('*')->from('config')->offset($offset)->limit($limit);
        $query->where(['collection'=>$collection]);
        if(!empty($name)){
            $query->andWhere(['name'=>$name]);
        }
        return $query->all();
    }

    public function getDisplayLabel($label4create, $label4update = ''){
        return $this->isNewRecord?$label4create:$label4update;
    }

    public function addRule($attributes, $validator, $options = [])
    {
        $validators = $this->getValidators();
        $validators->append(Validator::createValidator($validator, $this, (array) $attributes, $options));
        return $this;
    }
}
