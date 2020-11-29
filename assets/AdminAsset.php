<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
 public $sourcePath = '@app/modules/admin/web';

 public $css = [];
 public $js = [
    'js/jquery-3.5.1.min',
 ];
 public $jsOptions = array(
    'position' => \yii\web\View::POS_HEAD
);
 
 public $depends = [];
}