<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12 mb-3 text-center">
                <?php if (Yii::$app->user->isGuest): ?>
                    <h2>Ви не увійшли до системи</h2>
                <?php else: ?>
                    <h2>Ви увійшли як:</h2>
                    <p>Логін: <?= Yii::$app->user->identity->username ?></p>
                    <p>Пароль: <?= Yii::$app->user->identity->password_hash ?></p>
                    <p>Роль: <?= Yii::$app->user->identity->role ?></p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
