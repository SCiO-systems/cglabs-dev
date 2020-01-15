<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 13/1/2020
 * Time: 18:19
 */

namespace humhub\modules\globusfiles\models;


class ParentFolder
{
    public $name;
    public $url;

    function __construct($name,$url) {
        $this->name = $name;
        $this->url = $url;
    }

}
