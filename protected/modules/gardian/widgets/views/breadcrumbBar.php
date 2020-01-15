<?php

use yii\helpers\Html;

/* @var $folder  \humhub\modules\globusfiles\models\CurrentFolder */


$visibilityIcon = 'fa-unlock-alt';
$visibilityTitle = 'This folder is public.';
$visibilityIcon = 'fa-unlock-alt' ;

?>

<div class="panel panel-default" style="margin-bottom:10px;">
    <div class="panel-head">
        <ol id="globusfiles-crumb" class="breadcrumb" dir="ltr">
            <?php foreach ($folder->getCrumb() as $parentFolder): ?>
                <?php
                    $url = $parentFolder->url;
                    $name = $parentFolder->name;

                ?>
                <li>
                    <a href="<?= $url ?>">
                        <?= $name ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <?php if(!$folder->isRoot()) : ?>
                <li class="folder-visibility tt" data-placement="left"  title="<?= $folder->getVisibilityTitle() ?>">
                    <i class="fa <?= $visibilityIcon ?> fa-lg"></i>
                </li>
            <?php endif; ?>
        </ol>
    </div>
</div>
