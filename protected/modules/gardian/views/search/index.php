<?php

use yii\helpers\Html;
use humhub\modules\globusfiles\widgets\FolderView;
use humhub\modules\globusfiles\widgets\FileListContextMenu;
use humhub\widgets\Button;

/* @var $contentContainer humhub\components\View */
/* @var $datasets[] string */
/* @var $publications[] string */

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
            <?=
            Html::textInput(
                "keywords",
                "",
                ['data-ui-markdown' => "true", "class" => "form-control humhub-ui-richtext"])
            ?>
        </div>
        <hr>
        <?=
        Button::primary('Search')
            ->icon('fa fa-search')
            ->cssClass('btn btn-info')
            ->submit();
        ?>
    </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Search Results</strong>
            <div class="panel-body">
                <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                    <li class="active">
                        <a href="#datasets" data-toggle="tab">Datasets</a>
                    </li>
                    <li>
                        <a href="#publications" data-toggle="tab">Publications</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="datasets">
                <?php foreach ($datasets as $dataset): ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="media">
                                    <?= $dataset; ?>
                                </div>
                            </div>
                        </div>
                <?php endforeach; ?>
            </div>
            <div class="tab-pane" id="publications">
                <?php foreach ($publications as $publications): ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="media">
                                <?= $publications; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?= Html::endForm(); ?>




