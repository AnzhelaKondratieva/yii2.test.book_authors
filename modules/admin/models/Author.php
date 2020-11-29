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
}
