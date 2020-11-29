<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\admin\models\Author;

class AuthorForm extends Author
{
    public function rules()
    {
        return [
            [['surname', 'name'], 'required'],
            [['surname'], 'string', 'min' => 3],
            [['parentname'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'parentname' => 'Отчество',
        ];
    }
}