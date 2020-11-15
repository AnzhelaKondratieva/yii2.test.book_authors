<?php

namespace app\models;

use yii\db\ActiveRecord;

class Author extends ActiveRecord
{

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
