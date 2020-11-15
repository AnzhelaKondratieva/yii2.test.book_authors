<?php

namespace app\models;

use yii\db\ActiveRecord;

class Book extends ActiveRecord
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
    
}