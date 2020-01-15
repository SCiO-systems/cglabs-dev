<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 26/12/2019
 * Time: 13:02
 */


use humhub\modules\globusfiles\widgets\BreadcrumbBar;
use humhub\modules\globusfiles\widgets\FileListMenu;
use humhub\modules\globusfiles\widgets\FileList;
use humhub\modules\globusfiles\widgets\FileSelectionMenu;
use humhub\modules\file\widgets\UploadProgress;
use yii\helpers\Html;

/* @var $this humhub\components\View */
/* @var $contentContainer humhub\components\View */
/* @var $folder humhub\modules\globusfiles\models\CurrentFolder */
?>


<?= Html::beginTag('div', $options) ?>
<?= BreadcrumbBar::widget(['folder' => $folder, 'contentContainer' => $contentContainer]) ?>
<?= FileListMenu::widget([
    'folder' => $folder,
    'contentContainer' => $contentContainer,
]) ?>

<div id="fileList">
    <?= FileList::widget([
        'folder' => $folder,
        'contentContainer' => $contentContainer,
    ])?>
</div>


<?= Html::endTag('div') ?>
