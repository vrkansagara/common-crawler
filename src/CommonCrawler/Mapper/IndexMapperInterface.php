<?php


namespace CommonCrawler\Mapper;


interface IndexMapperInterface
{
    public function find($id);

    public function findAll();

    public function findAllActive();

    public function findAllInactive();

    public function insert(array $indexData);

    public function delete($id);

    public function flush();

    public function update($id, array $indexData);

    public function import();

    public function isExists($id);

    public function active($id);

    public function inActivate($id);

    public function activeAll();

    public function inActivateAll();

    public function createdBefore($timestamp);

    public function createdAfter($timestamp);

    public function createdBetween($fromTimestamp, $toTimestamp);

    public function updatedBefore($timestamp);

    public function updatedAfter($timestamp);

    public function updatedBetween($fromTimestamp, $toTimestamp);

}