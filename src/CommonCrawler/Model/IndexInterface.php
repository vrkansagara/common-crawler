<?php


namespace CommonCrawler\Model;


interface IndexInterface
{
    public function getIndex();

    public function getName();

    public function getTimegate();

    public function getCdxApi();

    public function getStatus();
}