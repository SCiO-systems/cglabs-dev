<?php

use humhub\modules\globusfiles\models\File;
use humhub\modules\file\libs\FileHelper;
use humhub\widgets\LinkPager;
use yii\helpers\Html;
use humhub\modules\globusfiles\widgets\FileSystemItem;
use humhub\modules\globusfiles\widgets\FileItem;

/* @var $itemsInFolder boolean */
/* @var $itemsSelectable boolean */
/* @var $canWrite boolean */
/* @var $folder \humhub\modules\globusfiles\models\CurrentFolder */
/* @var $rows \humhub\modules\globusfiles\models\GlobusItem[] */
/* @var $pagination \yii\data\Pagination */

?>
<?php if ($itemsInFolder) : ?>
    <div class="table-responsive">
        <table id="bs-table" class="table table-hover">
            <thead>
            <tr>
                <?php if ($itemsSelectable): ?>
                    <th class="text-center" style="width:38px;">
                        <?= Html::checkbox('allchk', false, ['class' => 'allselect']); ?>
                    </th>
                <?php endif; ?>

                <th class="text-left">
                    <?=  'Name' ?>
                </th>

                <th class="hidden-xxs"></th>

                <th class="hidden-xs text-right"  ?><?= 'Size' ?></th>
                <th class="hidden-xxs text-right" ?><?= 'Updated' ?></th>

                <?php if (!$folder->isAllPostedFiles()): // Files currently have no content object but the Post they may be connected to.  ?>
                    <th class="text-right"><?=  'Likes/Comments' ?></th>
                <?php endif; ?>

                <th class="hidden-xxs text-right"><?='Creator' ?></th>
            </tr>
            </thead>

            <?php foreach ($rows as $row) : ?>
                <?= FileItem::widget([
                    'row' => $row,
                    'itemsSelectable' => $itemsSelectable
                ]); ?>
            <?php endforeach; ?>

        </table>
        <?php if ($pagination) : ?>
            <div class="text-center">
                <?= LinkPager::widget(['pagination' => $pagination]); ?>
            </div>
        <?php endif; ?>
    </div>
<?php else : ?>
    <br/>
    <div class="folderEmptyMessage">
        <div class="panel">
            <div class="panel-body">
                <p>
                    <strong><?= 'This folder is empty.'; ?></strong>
                </p>
                <?php if ($canWrite): ?>
                    <?= 'Upload files or create a subfolder with the buttons on the top.' ?>
                <?php else: ?>
                    <?= 'Unfortunately you have no permission to upload/edit files.' ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
