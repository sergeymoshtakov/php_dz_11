<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]) ?>

<?= $form->field($model, 'file')->fileInput() ?>

<button><?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?></button>

<?php ActiveForm::end() ?>

<h2>Uploaded Files</h2>
<ul>
    <?php foreach ($uploadedFiles as $file): ?>
        <li>
            <?= Html::a(Html::encode($file), ['files/' . $file], ['target' => '_blank']) ?>
        </li>
    <?php endforeach; ?>
</ul>
