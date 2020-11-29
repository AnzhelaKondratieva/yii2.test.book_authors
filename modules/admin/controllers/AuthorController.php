<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Author;
use app\modules\admin\models\AuthorSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Sort;
use app\modules\admin\models\AuthorForm;

class AuthorController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $sort = new Sort([
            'attributes' => [
                'surname' => [
                    'asc' => ['surname' => SORT_ASC, 'surname' => SORT_ASC],
                    'desc' => ['surname' => SORT_DESC, 'surname' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Сортировать по фамилии',
                ],
            ],
        ]);

        $searchModel = new AuthorSearch();

        $model = new Author();

        if(Yii::$app->request->get()) {
            $dataProvider = $searchModel->search(Yii::$app->request->get());
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Author::find(),
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
        }

        $model= new AuthorForm();
        
        if(\Yii::$app->request->isAjax){
            if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
                $model->save();
            }
        } else {
            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'sort' => $sort,
                'model' => $model,
            ]);
        }
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('update',[
                'model'=>$model,
                'authors' => Author::find()->all(),
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Author::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}