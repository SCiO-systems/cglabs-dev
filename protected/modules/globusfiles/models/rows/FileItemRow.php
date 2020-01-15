<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */

namespace humhub\modules\globusfiles\models\rows;

/**
 * Created by PhpStorm.
 * User: buddha
 * Date: 30.08.2017
 * Time: 23:47
 */
abstract class FileItemRow extends AbstractFileItemRow
{
    /**
     * @var \humhub\modules\globusfiles\models\GlobusItem
     */
    public $item;

    /**
     * @inheritdoc
     */
    public function isSelectable()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function isSocialActionsAvailable()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return self::DEFAULT_COLUMNS;
    }

    /**
     * @inheritdoc
     */
    public function getParentFolderId()
    {
        return $this->item->parent_folder_id;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return $this->item->getItemType();
    }

    /**
     * @inheritdoc
     */
    public function getItemId()
    {
        return $this->item->getItemId();
    }

    /**
     * @inheritdoc
     */
    public function getLinkUrl()
    {
        return $this->item->getUrl();
    }

    /**
     * @inheritdoc
     */
    public function getEditUrl()
    {
        //return $this->item->getEditUrl();
        return "EDIT_URL";
    }

    /**
     * @inheritdoc
     */
    public function getModel()
    {
        return $this->item;
    }

    /**
     * @inheritdoc
     */
    public function getDisplayUrl()
    {
        return $this->item->getFullUrl();
    }

    /**
     * @inheritdoc
     */
    public function getMoveUrl()
    {
        //return $this->item->content->container->createUrl('/cfiles/move', ['fid' => $this->getParentFolderId()]);
        return "MOVE_URL";
    }

    /**
     * @inheritdoc
     */
    public function getIconClass()
    {
        //return $this->item->getIcon();
        return "ICON";
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        //return $this->item->getTitle();
        return "TITLE";
    }

    /**
     * @inheritdoc
     */
    public function getSize()
    {
        //return $this->item->getSize();
        return 10;
    }

    /**
     * @inheritdoc
     */
    public function getCreator()
    {
        //return $this->item->getCreator();
        return "CREATOR";
    }

    /**
     * @inheritdoc
     */
    public function getEditor()
    {
        return $this->item->getEditor();
    }

    /**
     * @inheritdoc
     */
    public function getUpdatedAt()
    {
        //return $this->item->content->updated_at;
        return "UPDATED";
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        //return $this->item->getDescription();
        return "DESCRIPTION";
    }

    /**
     * @inheritdoc
     */
    public function getVisibilityIcon()
    {
        //return $this->item->content->isPublic() ? 'fa-unlock-alt': 'fa-lock';
        return "fa-lock";
    }

    /**
     * @return string
     */
    public function getVisibilityTitle()
    {
        //return $this->item->getVisibilityTitle();
        return "Visibility Title";
    }
}
