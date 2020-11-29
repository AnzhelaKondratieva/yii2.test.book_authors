<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Book;
use app\modules\admin\models\BookSearch;
use app\modules\admin\models\Author;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\Sort;
use app\modules\admin\models\BookForm;


class BookController extends Controller
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

    function actionIndex()
    { 
        $sort = new Sort([
            'attributes' => [
                'name' => [
                    'asc' => ['name' => SORT_ASC, 'name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC, 'name' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Сортировать по названию',
                ],
            ],
        ]);

        $searchModel = new BookSearch();
       
        if(Yii::$app->request->get()) {
            $dataProvider = $searchModel->search(Yii::$app->request->get());
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Book::find()->joinWith('authors'),
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);
        }

        $model= new BookForm();
        
        if(\Yii::$app->request->isAjax){
            if ($model->load(Yii::$app->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');
                $authors = Author::findAll(Yii::$app->request->post('BookForm')['authors']);
                if(!empty($model->image))
                {
                    $model->image = $this->uploadImage($model->image);
                }
                $model->save();
                foreach($authors as $author) {
                    $model->link('authors', $author);
                }
            }
        } else {
            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'sort' => $sort,
                'model' => $model,
                'authors' => Author::find()->all(),
            ]);
        }
    }

    public function actionView($id)
    {
        $book = $this->findModel($id);
        return $this->render('view', [
            'model' => $book,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $authors = Author::findAll(Yii::$app->request->post('BookForm')['authors']);
            $model->image = UploadedFile::getInstance($model, 'image');
            if(!empty($model->image)) {
                $model->image = $this->uploadImage($model->image);
            }
            $model->save();
            foreach($authors as $author) {
                $model->link('authors', $author);
            }
            return $this->redirect(['index']);
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
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function uploadImage($image) 
    {
        $path = 'uploads/' . $image->baseName . '.' . $image->extension;
        $imagename = $image->baseName . '.' . $image->extension;
        $count = 0;
        if(file_exists($path)) {
            $count++;
            $path = 'uploads/' . $image->baseName . '_'.$count.'.' . $image->extension;
            $imagename = $image->baseName . '_'.$count.'.' . $image->extension;
        }
        
        $image->saveAs($path);

        return $imagename;
    }

}
