<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Url;
use app\assets\AdminAsset;
use yii\helpers\ArrayHelper;
use app\modules\admin\models\Author;
use yii\widgets\Pjax;

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php AdminAsset::register($this); ?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php Modal::begin([
    'id' => 'saveForm2Modal',
    'header' => '<h3 class="modal-title">Создать книгу</h3>',
    ]); ?>

    <?= $this->render('form', [
        'model' => $model,
        'authors' => $authors,
    ]) ?>

    <?php Modal::end(); ?>
    
    <button type="button" onclick="$('#saveForm2Modal').modal('show');" >Создать книгу</button>

    <?php echo $sort->link('name'); ?>

    <?php Modal::begin([
           'header'=>'<h4>Wait a bit...</h4>',
           'id'=>'modal',
           'size'=>'modal-lg',
       ]);
       echo "<div id='modalContent'></div>";
       Modal::end(); ?>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'usong-grid',
        'filterModel' => $searchModel,
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
            [
                'label' => 'Авторы',
                'value' => function ($data) {
                    $authors_name = '';
                    foreach($data->authors as $author) {
                       $authors_name .= $author->name . ', ';
                    }
                    return substr(trim($authors_name),0,-1);
                }
            ],
            'date',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function($url, $dataProvider, $key) {
                               return Html::button('Edit', ['value'=> Url::to(['book/update','id' => $dataProvider->id]), 
                               'class' => 'btn-update',
                               'data-pjax' => '0',]);},
                    ],
            ],
        ],
    ]); 
    ?>
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
    $('#book_form').on('beforeSubmit', function(){
            var formData = new FormData($('#book_form')[0]);
            $.ajax({
                url: $('#book_form').attr('action'),
                type: 'POST',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(res){
                    console.log(res);
                    $('#book_form')[0].reset();
                    $("#saveForm2Modal").modal('hide'); 
                },
                error: function(){
                    alert('Error!');
                }
            });
            return false;
        });
JS;
$this->registerJs($script);?>

