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
                <?php if (!empty($authors)): ?>
                    <h2>Результаты поиска</h2>
                    <div class="row">
                        <?php foreach ($authors as $author): ?>
                            <p>
                                <a href="<?= Url::to(['author/view', 'id' => $author['id']]); ?>">
                                    <?= Html::encode($author['name'] . " " . $author['surname']); ?>
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