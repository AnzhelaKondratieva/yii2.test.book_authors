<?php

namespace app\modules\admin\models;

use Yii;
use yii\data\Pagination;

class Author extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'authors';
    }
    
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['id' => 'book_id'])
            ->viaTable('authors_books', ['author_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['surname', 'name'], 'required'],
            [['surname'], 'string', 'min' => 3],
            [['parentname'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'parentname' => 'Отчество',
        ];
    }

    public function getSearchedAuthors($query, $page) 
    {
        $search = $this->cleanSearchString($query);
        if (empty($search)) {
            return [null, null];
        }

        $query = Author::find()->where(['like', 'name', $search])->orWhere(['like', 'surname', $search]);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => Yii::$app->params['pageSize'],
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);

        $authors = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        $data = [$authors, $pages];

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
