<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo Html::csrfMetaTags() ?>
    <?php echo Html::cssFile(YII_DEBUG ? '@web/css/eqatu.min.css' : '@web/css/eqatu.min.css?v=' . filemtime(Yii::getAlias('@webroot/css/eqatu.min.css'))) ?>
    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php echo $content ?>

<?php echo Html::jsFile('@web/js/all.js?v=' . filemtime(Yii::getAlias('@webroot/js/all.js'))) ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
