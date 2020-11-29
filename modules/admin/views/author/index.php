<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use app\assets\AdminAsset;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php AdminAsset::register($this); ?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php Modal::begin([
    'id' => 'saveFormModal',
    'options' => [
        
    ],
    'header' => '<h3 class="modal-title">Создать книгу</h3>',
    ]); ?>

    <?= $this->render('form', [
        'model' => $model,
    ]) ?>
    <?php Modal::end(); ?>
    
    <button type="button" onclick="$('#saveFormModal').modal('show');" >Создать автора</button>
    
    <?php echo $sort->link('surname'); ?>

    <?php Modal::begin([
           'header'=>'<h4>Wait a bit...</h4>',
           'id'=>'modal',
           'size'=>'modal-lg',
       ]);
       echo "<div id='modalContent'></div>";
       Modal::end(); ?>

    <?php Pjax::begin(['id' => 'grid-pjax']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'surname',
            'name',
            'parentname',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function($url, $dataProvider, $key) {
                               return Html::button('Edit', ['value'=> Url::to(['author/update','id' => $dataProvider->id]), 
                               'class' => 'btn-update',
                               'data-pjax' => '0',]);},
                    ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php
$script = <<< JS
$('button.btn-update').click(function(){
        var container = $('#modalContent');
        container.html('Загрузка данных...');
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        });
    $('#author_form').on('beforeSubmit', function(){
        $('#author_form').attr('action', 'admin/author/index');
            var data = $('#author_form').serialize();
            $.ajax({
                url: $('#author_form').attr('action'),
                type: 'POST',
                data: data,
                success: function(res){
                    console.log(res);
                    $('#author_form')[0].reset();
                    $("#saveFormModal").modal('hide'); 
                },
                error: function(){
                    alert('Error!');
                }
            });
            return false;
        });
JS;
$this->registerJs($script);?>