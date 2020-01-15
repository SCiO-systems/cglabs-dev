<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */

/**  @var $canWrite boolean * */
/**  @var $zipEnabled boolean * */
/**  @var $deleteSelectionUrl string * */
/**  @var $moveSelectionUrl string * */
/**  @var $makePublicUrl string * */
/**  @var $makePrivateUrl string * */
/**  @var $zipSelectionUrl string * */
/**  @var $folder \humhub\modules\globusfiles\models\CurrentFolder * */

?>


<div class="selectedOnly pull-left" style="margin-right:2px;">
    <div class="btn-group">
        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            (<span class='chkCnt'></span>) <?= 'Selected items...' ?> <span
                class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <?php if ($canWrite): ?>
            <li>
                <a href="#" class="selectedOnly filedelete-button" style="display:none"
                   data-action-click="deleteSelection"
                   data-action-submit
                   data-action-url="<?= $deleteSelectionUrl ?>">
                    <i class="fa fa-trash"></i> <?=  'Delete' ?>
                </a>
            </li>

            <li>
                <a href="#" class="selectedOnly filemove-button" style="display:none"
                   data-action-click="globusfiles.move"
                   data-action-submit
                   data-fid="<?= $folder->id ?>"
                   data-action-url="<?= $moveSelectionUrl ?>">
                    <i class="fa fa-arrows"></i> <?= 'Move' ?>
                </a>
            </li>


            <li>
                <a href="#" class="selectedOnly" style="display:none"
                   data-action-click="changeSelectionVisibility"
                   data-action-submit
                   data-fid="<?= $folder->id ?>"
                   data-action-url="<?= $makePublicUrl ?>">
                    <i class="fa fa-unlock-alt"></i> <?= 'Make Public' ?>
                </a>
            <li>

            <?php endif; ?>

        </ul>
    </div>
</div>
