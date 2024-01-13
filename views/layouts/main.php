<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Pjax;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="https://kit.fontawesome.com/8ed5ba582d.js" crossorigin="anonymous"></script>
    <script>

    </script>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Forum', 'url' => ['/forum/show']],
        ],
    ]);
    if(Yii::$app->user->isGuest){
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label'=>'Login', 'url'=>['/site/login']],
                ['label'=>'Registration', 'url'=>['/site/registration']],
            ],
        ]);
    }else{
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                    ['label'=>'Logout', 'url'=>['/site/logout']],
                    ['label'=>'News', 'url'=>['/news/news']],
            ],
        ]);
        echo Html::a('Profile' ,['/profile/show', 'id'=>Yii::$app->user->id], ['class'=>'nav-link']);
        Pjax::begin([
            'id'=>'navbar_pjax',
            'timeout'=>300000,
            'scrollTo'=>false,
        ]);
        echo Html::a('Уведомления' ,['/notification/show', 'id'=>Yii::$app->user->id], ['class'=>'nav-link not', 'data-pjax'=>0]);
        Pjax::end();
    }

    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; My Company <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
