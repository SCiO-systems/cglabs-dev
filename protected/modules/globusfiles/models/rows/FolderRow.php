<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */

namespace humhub\modules\globusfiles\models\rows;

use humhub\modules\globusfiles\models\GlobusFolder;
use Yii;

/**
 * Created by PhpStorm.
 * User: buddha
 * Date: 30.08.2017
 * Time: 23:34
 */

class FolderRow extends GlobusFolder
{
    /**
     * @var \humhub\modules\globusfiles\models\GlobusFolder
     */
    public $item;



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
}
