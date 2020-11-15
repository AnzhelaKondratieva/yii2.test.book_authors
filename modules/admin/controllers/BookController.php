<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Book;
use app\modules\admin\models\Author;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


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
        $book = Book::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $book->getAuthors(),
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearch($query = '', $page = 1)
    {
        $page = (int)$page;

        list($books, $pages) = (new Book())->getSearchedBooks($query, $page);

        return $this->render(
            'search',
            compact('books', 'pages')
        );
    }

    public function actionView($id)
    {
        $book = $this->findModel($id);
        return $this->render('view', [
            'model' => $book,
        ]);
    }

    public function actionCreate()
    {
        $model = new Book();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            $author = Author::findOne(Yii::$app->request->post('Book')['authors']);
            if(!empty($model->image))
            {
                $path = 'uploads/' . $model->image->baseName . '.' . $model->image->extension;
                $imagename = $model->image->baseName . '.' . $model->image->extension;
                $count = 0;
                if(file_exists($path)) {
                    $count++;
                    $path = 'uploads/' . $model->image->baseName . '_'.$count.'.' . $model->image->extension;
                    $imagename = $model->image->baseName . '_'.$count.'.' . $model->image->extension;
                }
                
                $model->image->saveAs($path);
                $model->image = $imagename;
            }
            
            $model->save();
            $model->link('authors', $author);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'authors' => Author::find()->all(),
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
             $model->image = UploadedFile::getInstance($model, 'image');

             if(!empty($model->image))
             {
                 $path = 'uploads/' . $model->image->baseName . '.' . $model->image->extension;
                 $imagename = $model->image->baseName . '.' . $model->image->extension;
                 $count = 0;
                 if(file_exists($path)) {
                     $count++;
                     $path = 'uploads/' . $model->image->baseName . '_'.$count.'.' . $model->image->extension;
                     $imagename = $model->image->baseName . '_'.$count.'.' . $model->image->extension;
                 }
                 
                 $model->image->saveAs($path);
                 $model->image = $imagename;
                 $model->save();
             }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
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

}
