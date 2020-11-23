<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\map\assets;

use yii\web\AssetBundle;

class PowerAsset extends AssetBundle
{

    public $publishOptions = [
        'forceCopy' => true
    ];
    public $sourcePath = '@power/resources';
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $css = ['css/humhub.power.css'];
    public $js = ['js/humhub.power.js'];
}
