<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить данную книгу?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute'=>'image',
                'value'=> Yii::$app->homeUrl.'uploads/'.$model->image,
                'format' => ['image',['width'=>'100','height'=>'100']],
            ],
            [
                'attribute'=>'authors',
                'value'=> $model->authors->surname,
            ],
            'description',
            'date',
        ],
    ]) ?>

</div>
