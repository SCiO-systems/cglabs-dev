<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\globusfiles\widgets;

use humhub\modules\globusfiles\models\GlobusItem;
use humhub\modules\globusfiles\models\CurrentFolder;
use humhub\modules\globusfiles\models\rows\AbstractFileSystemItemRow;
use humhub\widgets\JsWidget;
use Yii;

/**
 * @inheritdoc
 */
class FileItem extends JsWidget
{

    /**
     * @inheritdoc
     */
    public $jsWidget = 'globusfiles.FileItem';

    /**
     * @var GlobusItem
     */
    public $row;

    /**
     * @var boolean
     */
    public $itemsSelectable = true;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->row->showSelect = $this->itemsSelectable;

        return $this->render('fileItem', [
            'row' => $this->row,
            'options' => $this->getOptions()
        ]);
    }

    public function getData() {
        return [
            'globusfiles-item' => $this->row->getFullUrl(),
            'globusfiles-url' => $this->row->getUrl(),
            'globusfiles-editable' => $this->row->canEdit(),
            'globusfiles-url-full' => $this->row->getDisplayUrl(),
            'globusfiles-wall-url' => $this->row->getWallUrl(),
            'globusfiles-edit-url' => ($this->row->canEdit()) ? $this->row->getEditUrl() : '',
            'globusfiles-move-url' => ($this->row->canEdit()) ? $this->row->getMoveUrl() : '',
        ];
    }

}
