<?php

namespace CommonCrawler\Mapper\Sqlite;

use CommonCrawler\Mapper\IndexMapperInterface;
use CommonCrawler\Model\IndexInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\Hydrator\HydratorInterface;


class IndexMapper implements IndexMapperInterface
{
    protected $tableName = 'common_index';

    public function findAllActive()
    {
        // TODO: Implement findAllActive() method.
    }

    public function findAllInactive()
    {
        // TODO: Implement findAllInactive() method.
    }

    /**
     * @var \Zend\Db\Adapter\AdapterInterface
     */
    protected $dbAdapter;

    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    protected $hydrator;

    /**
     * @var \SampleBlog\Model\PostInterface
     */
    protected $indexPrototype;


    public function __construct(
        AdapterInterface $dbAdapter,
        HydratorInterface $hydrator,
        IndexInterface $indexPrototype
    )
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->indexPrototype = $indexPrototype;
    }

    /**
     * @todo improve $postPrototype
     * @param $id
     * @return object
     */
    public function find($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('common_index');
        $select->where(array('id = ?' => $id));

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), $this->indexPrototype);
        }

        throw new \InvalidArgumentException("Common Index with given ID:{$id} not found.");
    }

    public function findAll()
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('common_index');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {

            $resultSet = new HydratingResultSet($this->hydrator, $this->indexPrototype);
            return $resultSet->initialize($result);
        }

        die("no data");
    }

    public function insert(array $indexData)
    {
        // TODO: Implement insert() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function flush()
    {
        $sql = new Sql($this->dbAdapter);
        $truncate = $sql->delete('common_index')->where('1=1');
        $stmt = $sql->prepareStatementForSqlObject($truncate);
        $result = $stmt->execute();
    }

    public function update($id, array $indexData)
    {
        // TODO: Implement update() method.
    }

    public function import()
    {
        // TODO: Implement import() method.
    }

    public function isExists($id)
    {
        // TODO: Implement isExists() method.
    }

    public function active($id)
    {
        // TODO: Implement active() method.
    }

    public function deactivate($id)
    {
        // TODO: Implement deactivate() method.
    }

    public function inactivate($id)
    {
        // TODO: Implement inactivate() method.
    }

    public function activeAll()
    {
        // TODO: Implement activeAll() method.
    }

    public function inactivateAll()
    {
        // TODO: Implement inactivateAll() method.
    }

}