<?php
namespace yiipal\base\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\ActionEvent;
use yii\base\Event;
use yii\base\InvalidParamException;
use yii\base\ModelEvent;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yiipal\node\models\Node;

/**
 * Base controller
 */
class BaseController extends Controller
{
    const EVENT_YIIPAL_FIND_ONE_RECORD = 'event_yiipal_find_one_record';
    public $session;

    public function init(){
        parent::init();
        $this->session = Yii::$app->session;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction(){
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        return true;
    }

    public function actionList()
    {
        return $this->render('index', [
        ]);
    }

    /**
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Node('article');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->nid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing File model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->nid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * Displays a single model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds a model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Node::findOne(['nid'=>$id]);
        if ($model !== null) {
            $model->trigger(self::EVENT_YIIPAL_FIND_ONE_RECORD);
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function arg($index = NULL, $path = NULL){
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

    public function render($view, $params = []){
        if(Yii::$app->request->isAjax){
            return parent::renderAjax($view, $params);
        }
        return parent::render($view, $params);
    }
}
