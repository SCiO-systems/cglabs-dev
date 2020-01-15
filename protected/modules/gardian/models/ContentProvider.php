<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 15/1/2020
 * Time: 15:17
 */

namespace humhub\modules\gardian\models;

class ContentProvider
{

    public $providerLink;
    public $contentProviderID;
    public $contentProviderName;
    public $hdl;

    /**
     * ContentProvider constructor.
     * @param $providerLink
     * @param $contentProviderID
     * @param $contentProviderName
     * @param $hdl
     */
    public function __construct($providerLink, $contentProviderID, $contentProviderName, $hdl)
    {
        $this->providerLink = $providerLink;
        $this->contentProviderID = $contentProviderID;
        $this->contentProviderName = $contentProviderName;
        $this->hdl = $hdl;
    }

    /**
     * @return mixed
     */
    public function getProviderLink()
    {
        return $this->providerLink;
    }

    /**
     * @param mixed $providerLink
     */
    public function setProviderLink($providerLink)
    {
        $this->providerLink = $providerLink;
    }

    /**
     * @return mixed
     */
    public function getContentProviderID()
    {
        return $this->contentProviderID;
    }

    /**
     * @param mixed $contentProviderID
     */
    public function setContentProviderID($contentProviderID)
    {
        $this->contentProviderID = $contentProviderID;
    }

    /**
     * @return mixed
     */
    public function getContentProviderName()
    {
        return $this->contentProviderName;
    }

    /**
     * @param mixed $contentProviderName
     */
    public function setContentProviderName($contentProviderName)
    {
        $this->contentProviderName = $contentProviderName;
    }

    /**
     * @return mixed
     */
    public function getHdl()
    {
        return $this->hdl;
    }

    /**
     * @param mixed $hdl
     */
    public function setHdl($hdl)
    {
        $this->hdl = $hdl;
    }
}
