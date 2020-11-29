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


   
}
