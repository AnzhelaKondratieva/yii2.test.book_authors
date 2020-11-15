<?php

use app\components\TreeWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <?php if (!empty($books)): ?>
                    <h2>Результаты поиска</h2>
                    <div class="row">
                        <?php foreach ($books as $book): ?>
                            <p>
                                <a href="<?= Url::to(['book/view', 'id' => $book['id']]); ?>">
                                    <?= Html::encode($book['name']); ?>
                                </a>
                            </p>
                        <?php endforeach; ?>
                    </div>
                    <?= LinkPager::widget(['pagination' => $pages]); ?>
                <?php else: ?>
                    <p>По вашему запросу ничего не найдено.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>