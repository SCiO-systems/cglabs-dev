<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */

namespace humhub\modules\globusfiles\models\rows;

use Yii;
use humhub\modules\globusfiles\models\GlobusFile;

/**
 * Created by PhpStorm.
 * User: buddha
 * Date: 30.08.2017
 * Time: 23:34
 */

class FileRow extends GlobusFile
{

    /**
     * @var \humhub\modules\globusfiles\models\GlobusFile
     */
    public $item;

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        //return $this->item->getDownloadUrl(true);
        return "Download URL";
    }

    /**
     * @inheritdoc
     */
    public function getBaseFile()
    {
        //return $this->item->baseFile;
        return null;
    }

    /**
     * @return boolean
     */
    public function canEdit()
    {
       // return $this->item->content->canEdit();
        return TRUE;
    }
}
