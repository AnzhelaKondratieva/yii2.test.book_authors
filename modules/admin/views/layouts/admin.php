<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE HTML>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <!--header-->		
        <div class="header">  
            <div class="container">
                <!--start-top-nav-->
                <div class="top-menu">
                    <span class="menu"> </span> 
                    <ul>
                        <li class="active"><a href="<?=  \yii\helpers\Url::to(['author/index'])?>">Авторы</a></li>						
                        <li><a href="<?=  \yii\helpers\Url::to(['book/index'])?>">Книги</a></li>	
                        						
                        <div class="clearfix"> </div>
                    </ul>
                </div>
                <div class="clearfix"></div>

                <!--//End-top-nav-->					
            </div>
        </div>
        <!--/header-->
        <div class="content">
            <div class="container">
                <div class="content-grids">
                    <div class="col-md-12">
                        <?=$content?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!---->
        <div class="footer">
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>