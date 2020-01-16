<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 16/1/2020
 * Time: 17:04
 */

namespace humhub\modules\gardian\models;


class Publication
{
    public $accessibility;
    public $title;
    public $publicationYear;
    public $authors;
    public $contentProvider;
    public $summary;
    public $citation;
    public $doi;
    public $quantumId;

    /**
     * Publication constructor.
     * @param $accessibility
     * @param $title
     * @param $publicationYear
     * @param $authors
     * @param $contentProvider
     * @param $summary
     * @param $citation
     * @param $doi
     * @param $quantumId
     */
    public function __construct($accessibility, $title, $publicationYear, $authors, $contentProvider, $summary, $citation, $doi, $quantumId)
    {
        $this->accessibility = $accessibility;
        $this->title = $title;
        $this->publicationYear = $publicationYear;
        $this->authors = $authors;
        $this->contentProvider = $contentProvider;
        $this->summary = $summary;
        $this->citation = $citation;
        $this->doi = $doi;
        $this->quantumId = $quantumId;
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

    /**
     * @return mixed
     */
    public function getQuantumId()
    {
        return $this->quantumId;
    }

    /**
     * @param mixed $quantumId
     */
    public function setQuantumId($quantumId)
    {
        $this->quantumId = $quantumId;
    }



}
