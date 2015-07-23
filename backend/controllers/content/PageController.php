<?php
namespace backend\controllers\content;

use Yii;
use yii\data\ActiveDataProvider;
use yiipal\cck\models\FieldModel;
use yiipal\node\controllers\NodeController;
use yiipal\node\models\Node;
/**
 * Book controller
 */
class PageController extends NodeController
{
    public function init(){
        parent::init();
        $this->session->set('nodeType', $this->arg(0));
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }

    public function actionList2(){
        $type = $this->arg(0);
        $dataProvider = new ActiveDataProvider([
            'query' => Node::findQuery($type),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    //'nid' => SORT_ASC,
                    'company' => SORT_ASC,
                ]
            ],
        ]);
        //$dataProvider->getModels();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionUpdate2()
    {
        $nodeType = $this->arg(0);
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/node/list/'.$nodeType]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        return $this->render('update');
    }

    public function actionCreate2()
    {
        $nodeType = $this->arg(0);
        //FIXME:检查类型是否存在
        if(empty($nodeType)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model = new Node($nodeType);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/node/list/'.$nodeType]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        return $this->render('update');
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $nodeType = $this->arg(0);
        $fields = FieldModel::findAll(['collection'=>"field.node.$nodeType"]);
        foreach($fields as $field){
            $fieldClass = $field->data_field_class;
            $fieldClass::$tableName = $field->name;
            $fieldModel = $fieldClass::findOne(['nid'=>$id]);
            if($fieldModel){
                $fieldModel->delete();
            }
        }
        $this->findModel($id)->delete();
        return $this->redirect(['/node/list/'.$nodeType]);
    }
}
