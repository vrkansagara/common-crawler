<?php


namespace CommonCrawl\Model;


class Index implements IndexInterface
{
    private $index;
    private $name;
    private $timegate;
    private $cdx_api;
    private $status;

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param mixed $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCdxApi()
    {
        return $this->cdx_api;
    }

    /**
     * @param mixed $cdx_api
     */
    public function setCdxApi($cdx_api)
    {
        $this->cdx_api = $cdx_api;
    }

    /**
     * @return mixed
     */
    public function getTimegate()
    {
        return $this->timegate;
    }

    /**
     * @param mixed $timegate
     */
    public function setTimegate($timegate)
    {
        $this->timegate = $timegate;
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
        $this->status = ((int)$status == 1) ? 'Active' : 'Inactive';
    }


}