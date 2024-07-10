<?php

use yii\helpers\Html;

$this->title = 'Delete Account';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-delete-account">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Are you sure you want to delete your account?</p>

    <?= Html::a('Yes', ['delete-account'], ['class' => 'btn btn-danger']) ?>
    <?= Html::a('No', ['index'], ['class' => 'btn btn-primary']) ?>

</div>
