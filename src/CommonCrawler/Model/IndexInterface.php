<?php


namespace CommonCrawler\Model;


interface IndexInterface
{
    public function getCindex();

    public function getName();

    public function getTimegate();

    public function getCdxApi();

    public function getStatus();
}