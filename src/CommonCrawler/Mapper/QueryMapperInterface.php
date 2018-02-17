<?php

namespace CommonCrawler\Mapper;


interface QueryMapperInterface
{
    public function findAll();

    public function findAllActive();

    public function findAllInactive();

    public function find($id);

    public function insert(array $values);

    public function delete($id);

    public function flush();

    public function importSample();

    public function isExists($id);

    public function active($id);

    public function inActive($id);

    public function activeAll();

    public function inActiveAll();

    public function createdBefore($timestamp);

    public function createdAfter($timestamp);

    public function createdBetween($fromTimestamp, $toTimestamp);

    public function updatedBefore($timestamp);

    public function updatedAfter($timestamp);

    public function updatedBetween($fromTimestamp, $toTimestamp);

}