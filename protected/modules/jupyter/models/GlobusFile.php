<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 26/12/2019
 * Time: 11:30
 */

namespace humhub\modules\globusfiles\models;

class GlobusFile extends GlobusItem
{
    /**
     * @inheritdoc
     */
    public function getIcon()
    {
        return 'fa-file';
    }

    public function getUrl()
    {
        return $this->getUrl();
    }

    /**
     * @inheritdoc
     */
    public function getBaseFile()
    {
        return null;
    }

    /**
     * @return boolean
     */
    public function canEdit()
    {
        return TRUE;
    }

    /**
     * @inheritdoc
     */
    public function getIconClass()
    {
        return $this->getIcon();
    }


}
