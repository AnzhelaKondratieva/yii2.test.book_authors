<?php

namespace app\modules\admin\models;

use Yii;
use yii\data\Pagination;
use yii\web\UploadedFile;
use yii\behaviors\TimestampBehavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;

class Book extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'books';
    }
    
    public function getAuthors()
    {

        return $this->hasMany(Author::className(), ['id' => 'author_id'])
            ->viaTable('authors_books', ['book_id' => 'id']);
    }

    // public function behaviors()
    // {
    //     return [
    //         TimestampBehavior::className(),
    //         'saveRelations' => [
    //             'class'     => SaveRelationsBehavior::className(),
    //             'relations' => [
    //                 'authors',
    //             ],
    //         ],
    //     ];
    // }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string'],
            [['image'], 'file', 'extensions' => 'png, jpg', 'maxSize' => 1024 * 1024 * 5],
            [['date'], 'default', 'value' => null],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'image' => 'Изображение',
            'author_id'=> 'Автор',
            'date' => 'Дата',
        ];
    }

    public function getSearchedBooks($query, $page) 
    {
        $search = $this->cleanSearchString($query);
        if (empty($search)) {
            return [null, null];
        }

        $query = Book::find()->where(['like', 'name', $search]);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => Yii::$app->params['pageSize'],
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);

        $books = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        $data = [$books, $pages];

        return $data;
    }

    protected function cleanSearchString($search) {
        $search = iconv_substr($search, 0, 64);
        $search = preg_replace('#[^0-9a-zA-ZА-Яа-яёЁ]#u', ' ', $search);
        $search = preg_replace('#\s+#u', ' ', $search);
        $search = trim($search);
        return $search;
    }
}
