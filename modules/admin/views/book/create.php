<?php

use yii\helpers\Html;


$this->title = 'Создать книгу';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('form', [
        'model' => $model,
        'authors' => $authors,
    ]) ?>

</div>
