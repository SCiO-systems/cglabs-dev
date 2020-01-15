<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 15/1/2020
 * Time: 15:13
 */

namespace humhub\modules\gardian\models;

class File
{
    public $filename;
    public $contentType;
    public $accessibility;
    public $downloadLink;

    /**
     * File constructor.
     * @param $filename
     * @param $contentType
     * @param $accessibility
     * @param $downloadLink
     */
    public function __construct($filename, $contentType, $accessibility, $downloadLink)
    {
        $this->filename = $filename;
        $this->contentType = $contentType;
        $this->accessibility = $accessibility;
        $this->downloadLink = $downloadLink;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param mixed $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @return mixed
     */
    public function getAccessibility()
    {
        return $this->accessibility;
    }

    /**
     * @param mixed $accessibility
     */
    public function setAccessibility($accessibility)
    {
        $this->accessibility = $accessibility;
    }

    /**
     * @return mixed
     */
    public function getDownloadLink()
    {
        return $this->downloadLink;
    }

    /**
     * @param mixed $downloadLink
     */
    public function setDownloadLink($downloadLink)
    {
        $this->downloadLink = $downloadLink;
    }
}
