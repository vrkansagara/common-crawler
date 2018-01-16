<?php


namespace CommonCrawl\Mapper;


interface IndexMapperInterface
{
    public function find($id);

    public function findAll();

    public function insert(array $indexData);

    public function delete($id);

    public function flush();

    public function update($id, array $indexData);

    public function import();

    public function isExists($id);

    public function active($id);

    public function inactivate($id);

    public function activeAll();

    public function inactivateAll();
}