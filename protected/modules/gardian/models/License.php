<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 15/1/2020
 * Time: 15:19
 */

namespace humhub\modules\gardian\models;

class License
{

    public $term;
    public $url;
    public $image;

    /**
     * License constructor.
     * @param $term
     * @param $url
     * @param $image
     */
    public function __construct($term, $url, $image)
    {
        $this->term = $term;
        $this->url = $url;
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * @param mixed $term
     */
    public function setTerm($term)
    {
        $this->term = $term;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }




}
