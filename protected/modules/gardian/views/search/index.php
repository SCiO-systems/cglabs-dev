<?php

use yii\helpers\Html;
use humhub\modules\globusfiles\widgets\FolderView;
use humhub\modules\globusfiles\widgets\FileListContextMenu;
use humhub\widgets\Button;

/* @var $contentContainer humhub\components\View */

$bundle = \humhub\modules\gardian\assets\GardianAsset::register($this);

$this->registerJsConfig('gardian', [
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

<?= Html::beginForm('./search', 'POST', ['data-target' => '#globalModal', 'id' => 'gardian-form']); ?>
<div id="gardian-container" class="panel panel-default gardian-content">
    <div class="panel-body">
        <div id="contentForm_message" class="focusMenu">
            <div contenteditable="true" data-ui-markdown="true" class="form-control humhub-ui-richtext">
                <div class="" contenteditable="true">Search GARDIAN Resources</div>
            </div>
        </div>
        <hr>
        <?=
        Html::submitButton('Save', ['class' => 'fa  fa-search btn btn-info'])
        ?>
    </div>
    </div>
</div>
<?= Html::endForm(); ?>




