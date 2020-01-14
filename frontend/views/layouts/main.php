<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<?= $content ?>

<script src="/<?= \common\helpers\AssetUrlHelper::include('js/materialize.min.js') ?>"></script>
<script src="/<?= \common\helpers\AssetUrlHelper::include('js/lazyload.js') ?>"></script>
<script src="/<?= \common\helpers\AssetUrlHelper::include('js/main.js') ?>"></script>
<script src="/<?= \common\helpers\AssetUrlHelper::include('build/js/app.js') ?>"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
