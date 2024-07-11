<?php

use dosamigos\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\helpers\Url;

$this->title = 'File Server';

echo CKEditor::widget([
    'name' => 'content',
    'preset' => 'full',
    'clientOptions' => [
        'filebrowserBrowseUrl' => Url::to(['elfinder/manager']),
        'filebrowserUploadUrl' => Url::to(['elfinder/manager', 'path' => 'some/sub/path']),
    ],
]);
