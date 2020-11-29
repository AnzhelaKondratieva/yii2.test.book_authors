<?php

use yii\helpers\Html;
?>
<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('form', [
        'model' => $model,
        'authors' => $authors,
    ]) ?>

</div>