<?php
/**
 * Created by PhpStorm.
 * User: vallabh
 * Date: 03/02/18
 * Time: 3:46 PM
 */

namespace CommonCrawler\Model;


class Query implements QueryInterface
{
    private $query;
    private $cindexId;
    private $status;
    private $result;
    private $pageGenerated;
    private $createdAt;
    private $updatedAt;

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return mixed
     */
    public function getCindexId()
    {
        return $this->cindexId;
    }

    /**
     * @param mixed $cindexId
     */
    public function setCindexId($cindexId)
    {
        $this->cindexId = $cindexId;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getPageGenerated()
    {
        return $this->pageGenerated;
    }

    /**
     * @param mixed $pageGenerated
     */
    public function setPageGenerated($pageGenerated)
    {
        $this->pageGenerated = $pageGenerated;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }


}