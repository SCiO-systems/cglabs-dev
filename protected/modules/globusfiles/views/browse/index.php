<?php

use yii\helpers\Html;
use humhub\modules\globusfiles\widgets\FolderView;
use humhub\modules\globusfiles\widgets\FileListContextMenu;

/* @var $folder humhub\modules\globusfiles\models\CurrentFolder */
/* @var $contentContainer humhub\components\View */


$bundle = \humhub\modules\globusfiles\assets\GlobusfilesAsset::register($this);

$this->registerJsConfig('globusfiles', [
    'text' => [
        'confirm.delete' => 'Do you really want to delete this {number} item(s) with all subcontent?',
        'confirm.delete.header' =>  '<strong>Confirm</strong> delete file',
        'confirm.delete.confirmText' =>  'Delete'
    ],
    'showUrlModal' => [
        'head' => '<strong>File</strong> url',
        'headFile' => '<strong>File</strong> download url',
        'headFolder' =>'<strong>Folder</strong> url',
        'info' => 'Copy to clipboard',
        'buttonClose' => 'Close',
    ]
]);


?>

<?= Html::beginForm(null, null, ['data-target' => '#globalModal', 'id' => 'globusfiles-form']); ?>
<div id="globusfiles-container" class="panel panel-default globusfiles-content">

    <div class="panel-body">

        <?=  FolderView::widget([
            'contentContainer' => $contentContainer,
            'folder' => $folder
        ])?>

    </div>
</div>
<?= Html::endForm(); ?>

<?= FileListContextMenu::widget(['folder' => $folder]); ?>


