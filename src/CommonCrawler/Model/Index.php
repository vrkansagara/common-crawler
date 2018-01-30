<?php


namespace CommonCrawler\Model;


class Index implements IndexInterface
{
    private $cindex;
    private $name;
    private $timegate;
    private $cdx_api;
    private $status;

    /**
     * @return mixed
     */
    public function getCindex()
    {
        return $this->cindex;
    }

    /**
     * @param mixed $cindex
     */
    public function setCindex($cindex)
    {
        $this->cindex = $cindex;
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