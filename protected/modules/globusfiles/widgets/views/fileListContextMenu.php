<ul id="contextMenuFolder" class="contextMenu dropdown-menu" role="menu" style="display: none">
    <li><a tabindex="-1" href="#" data-action='download'><i class="fa fa-folder-open"></i><?=  'Open' ?></a></li>
<li><a tabindex="-1" href="#" data-action='show-url'><i class="fa fa-link"></i><?='Display Url' ?></a></li>
<li role="separator" class="divider editableOnly"></li>
<li><a tabindex="-1" href="#" data-action='edit-folder' class="editableOnly"><i class="fa fa-pencil"></i><?=  'Edit' ?></a></li>
<li><a tabindex="-1" href="#" data-action='delete' class="editableOnly"><i class="fa fa-trash"></i><?= 'Delete' ?></a></li>
<?php if ($canWrite): ?>
    <li><a tabindex="-1" href="#" data-action='move-files' class="editableOnly"><i class="fa fa-arrows"></i><?=  'Move' ?></a></li>
<?php endif; ?>

</ul>

<ul id="contextMenuFile" class="contextMenu dropdown-menu" role="menu"
    style="display: none">
    <li><a tabindex="-1" href="#" data-action='download'><i class="fa fa-exchange"></i><?=  'Transfer' ?></a></li>
    <li role="separator" class="divider editableOnly"></li>

    <?php if ($folder->isAllPostedFiles()): ?>
        <li><a tabindex="-1" href="#" data-action='edit-file' class="editableOnly"><i class="fa fa-pencil"></i><?= 'Edit'?></a></li>
        <li><a tabindex="-1" href="#" data-action='delete' class="editableOnly"><i class="fa fa-trash"></i><?=  'Delete' ?></a></li>
    <?php endif; ?>

</ul>

<ul id="contextMenuImage" class="contextMenu dropdown-menu" role="menu" style="display: none">
    <li><a tabindex="-1" href="#" data-action='download'><i class="fa fa-cloud-download"></i><?=  'Download' ?></a></li>
    <li><a tabindex="-1" href="#" data-action='show-post'><i class="fa fa-window-maximize"></i><?=  'Show Post'?></a></li>
    <li><a tabindex="-1" href="#" data-action='show-url'><i class="fa fa-link"></i><?=  'Display Url' ?></a></li>

    <?php if ($folder->isAllPostedFiles()): ?>
        <li role="separator" class="divider editableOnly"></li>
        <li><a tabindex="-1" href="#" data-action='edit-file' class="editableOnly"><i class="fa fa-pencil"></i><?= 'Edit' ?></a></li>
        <li><a tabindex="-1" href="#" data-action='delete' class="editableOnly"><i class="fa fa-trash"></i><?=  'Delete' ?></a></li>
        <?php if ($canWrite): ?>
            <li><a tabindex="-1" href="#" data-action='move-files' class="editableOnly"><i class="fa fa-arrows"></i><?=  'Move' ?></a></li>
        <?php endif; ?>
    <?php endif; ?>
</ul>

<ul id="contextMenuAllPostedFiles" class="contextMenu dropdown-menu" role="menu" style="display: none">
    <li><a tabindex="-1" href="#" data-action='download'><i class="fa fa-folder-open"></i><?=  'Open' ?></a></li>
    <li><a tabindex="-1" href="#" data-action='show-url'><i class="fa fa-link"></i><?=  'Display Url'?></a></li>
</ul>
