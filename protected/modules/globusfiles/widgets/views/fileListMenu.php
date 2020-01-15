<?php

use humhub\modules\globusfiles\widgets\FileSelectionMenu;
use humhub\modules\globusfiles\widgets\GlobusUploadButton;
use humhub\modules\file\widgets\FileHandlerButtonDropdown;
use humhub\modules\file\widgets\UploadButton;
use humhub\modules\file\widgets\UploadInput;
use humhub\widgets\Button;
use humhub\widgets\ModalButton;


/* @var $folder \humhub\modules\globusfiles\models\CurrentFolder */
/* @var $contentContainer \humhub\modules\content\components\ContentContainerActiveRecord */
/* @var $canUpload boolean */

$addFolderUrl = $contentContainer->createUrl('/globusfiles/edit/folder', ['path' => $folder->id]);
$editFolderUrl = $contentContainer->createUrl('/globusfiles/edit/folder', ['path' => $folder->id]);

//$uploadUrl = $contentContainer->createUrl('/cfiles/upload', ['fid' => $folder->id]);


$editFolderUrl = "EDIT_FOLDER_URL";
$uploadUrl = "UPLOAD_URL";
$fileHandlers = array();

$guid = Yii::$app->user->getGuid();
$username = Yii::$app->user->identity->username;

$redirectLink = "https://labs.scio.systems/index.php/u/".$username."/globusfiles/browse/upload";
$globusLink = "https://app.globus.org/file-manager?method=POST&label=GARDIAN LABS&action=".$redirectLink."&folderlimit=0&filelimit=1";

?>

<div class="clearfix files-action-menu">
    <?= FileSelectionMenu::widget([
        'folder' => $folder,
        'contentContainer' => $contentContainer,
    ]);?>

    <?php if($folder->parentFolder) : ?>
        <?= Button::back($folder->getBackUrl())->left()  ?>
    <?php endif; ?>

    <!-- FileList main menu -->
    <?php if ($folder->isAllPostedFiles()): ?>
        <div style="display:block;" class="pull-right">

            <!-- Directory dropdown -->
            <?php if ($canUpload): ?>
                <div class="btn-group">
                    <?= ModalButton::defaultType('Add directory')->load($addFolderUrl)->icon('fa-folder')->cssClass('dropdown-toggle')?>
                    <?php if (!$folder->isRoot()): ?>
                        <button id="directory-toggle" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <span class="caret"></span><span class="sr-only"></span>
                        </button>
                        <ul id="folder-dropdown" class="dropdown-menu">
                            <li class="visible">
                                <?= ModalButton::asLink('Edit directory')->load($editFolderUrl)->icon('fa-pencil'); ?>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?=
                Button::primary('Secure Upload')->icon('fa fa-cloud-upload')->cssClass('btn-success')
                ->link($globusLink);
            ?>

        </div>
    <?php endif; ?>
</div>
