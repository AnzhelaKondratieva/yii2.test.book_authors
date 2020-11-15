<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-sm-4">
        <form method="get" action="<?= Url::to(['author/search']); ?>" class="pull-right">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Поиск по авторам">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <p>
        <?= Html::a('Создать автора', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'surname',
            'name',
            'parentname',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
