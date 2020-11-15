<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Url;

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-sm-4">
        <form method="get" action="<?= Url::to(['book/search']); ?>" class="pull-right">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Поиск по книгам">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <p>
        <?= Html::a('Создать книгу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'description',
            [
                'label' => 'Изображение',
                'format' => 'raw',
                'value' => function($data){
                    return Html::img(Url::toRoute('../../uploads/'.$data->image),[
                        'alt'=>'картинка',
                        'style' => 'width:30px;'
                    ]);
                },
            ],
            'author.surname',
            'date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 
    ?>

</div>
