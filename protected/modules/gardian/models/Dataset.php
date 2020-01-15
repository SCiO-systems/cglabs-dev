<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 15/1/2020
 * Time: 15:03
 */

namespace humhub\modules\gardian\models;

class Dataset
{
    public $accessibility;
    public $title;
    public $publicationYear;
    public $authors;
    public $contentProvider;
    public $files;
    public $summary;
    public $license;
    public $citation;
    public $doi;

    function __construct($accessibility,$title,$publicationYear,$authors,$contentProvider,$files,$summary,$license,$citation,$doi) {
        $this->accessibility = $accessibility;
        $this->title = $title;
        $this->publicationYear = $publicationYear;
        $this->authors = $authors;
        $this->contentProvider = $contentProvider;
        $this->files = $files;
        $this->summary = $summary;
        $this->license = $license;
        $this->citation = $citation;
        $this->doi = $doi;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getPublicationYear()
    {
        return $this->publicationYear;
    }

    /**
     * @param mixed $publicationYear
     */
    public function setPublicationYear($publicationYear)
    {
        $this->publicationYear = $publicationYear;
    }

    /**
     * @return mixed
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @param mixed $authors
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;
    }

    /**
     * @return mixed
     */
    public function getContentProvider()
    {
        return $this->contentProvider;
    }

    /**
     * @param mixed $contentProvider
     */
    public function setContentProvider($contentProvider)
    {
        $this->contentProvider = $contentProvider;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * @return mixed
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param mixed $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return mixed
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * @param mixed $license
     */
    public function setLicense($license)
    {
        $this->license = $license;
    }

    /**
     * @return mixed
     */
    public function getCitation()
    {
        return $this->citation;
    }

    /**
     * @param mixed $citation
     */
    public function setCitation($citation)
    {
        $this->citation = $citation;
    }

    /**
     * @return mixed
     */
    public function getDoi()
    {
        return $this->doi;
    }

    /**
     * @param mixed $doi
     */
    public function setDoi($doi)
    {
        $this->doi = $doi;
    }
}
