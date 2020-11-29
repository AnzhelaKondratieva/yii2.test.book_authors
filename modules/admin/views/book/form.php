<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\admin\models\Author;
?>

<div class="category-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'id' => 'book_form',
        ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php if(!empty($model->image)): ?>
        <img src="/uploads/<?= $model->image?>" alt="">
    <?php endif; ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'authors')->dropDownList(ArrayHelper::map($authors, 'id', 'surname'),
        [
        'multiple'=>'multiple',           
        ]) 
    ?>
    
    <?= $form->field($model, 'date')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
