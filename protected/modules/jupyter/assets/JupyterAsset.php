<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\jupyter\assets;

use yii\web\AssetBundle;

class JupyterAsset extends AssetBundle
{

    public $publishOptions = [
        'forceCopy' => true
    ];
    public $sourcePath = '@globusfiles/resources';
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $css = ['css/humhub.jupyter.css'];
    public $js = ['js/humhub.jupyter.js'];
}
