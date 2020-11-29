<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\admin\models\Book;

class BookForm extends Book
{
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string'],
            [['image'], 'file', 'extensions' => 'png, jpg', 'maxSize' => 1024 * 1024 * 5],
            [['date'], 'default', 'value' => null],
        ];
    }


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
}