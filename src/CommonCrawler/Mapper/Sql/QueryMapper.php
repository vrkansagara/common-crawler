<?php

namespace CommonCrawler\Mapper\Sql;

use CommonCrawler\Mapper\QueryMapperInterface;
use CommonCrawler\Model\IndexInterface;
use CommonCrawler\Model\QueryInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Http\Client;
use Zend\Hydrator\HydratorInterface;


class QueryMapper implements QueryMapperInterface
{
    protected $tableName = 'common_query';
    /**
     * @var \Zend\Db\Adapter\AdapterInterface
     */
    protected $dbAdapter;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var IndexInterface
     */
    protected $indexPrototype;

    private $configuration;

    public function __construct(
        AdapterInterface $dbAdapter,
        HydratorInterface $hydrator,
        QueryInterface $indexPrototype,
        array $configuration
    )
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->indexPrototype = $indexPrototype;
        $this->configuration = $configuration;
    }

    /**
     * @todo improve $postPrototype
     * @param $id
     * @return object
     */
    public function find($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select($this->tableName);
        $select->where(array('cindex' => $id));

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
        $select = $sql->select($this->tableName);
        $select->order('id');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {

            $resultSet = new HydratingResultSet($this->hydrator, $this->indexPrototype);
            return $resultSet->initialize($result);
        }

        die("no data");
    }

    public function findAllActive()
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select($this->tableName);
        $select->where(
            array(
                'status' => (int)1
            )
        );

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->indexPrototype);
            return $resultSet->initialize($result);
        }

        die("no data");
    }

    public function findAllInactive()
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select($this->tableName);
        $select->where(
            array(
                'status' => (int)0
            )
        );
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
        $truncate = $sql->delete($this->tableName)->where('1=1');
        $stmt = $sql->prepareStatementForSqlObject($truncate);
        $result = $stmt->execute();
    }

    public function update($id, array $indexData)
    {
        // TODO: Implement update() method.
    }

    public function import()
    {
        $option = $this->configuration['CommonCrawler']['options'];
        $indexCollectionUrl = $option['index_collections']['json'];

        $httpClient = new Client();
        $httpClient->setUri($indexCollectionUrl);
        if (!empty($httpClient->send()->getBody())) {
            $response = json_decode($httpClient->send()->getBody());
        } else {
            $message = 'Unable to fetch the index list.';
        }

        $sql = new Sql($this->dbAdapter);
        $rowData = array();
        $rows = array();
        foreach ($response as $key => $row) {
            if (!$this->isExists($row->id)) {
                $rowData['cindex'] = $row->id;
                $rowData['name'] = $row->name;
                $rowData['timegate'] = $row->timegate;
                $rowData['cdx_api'] = $row->{'cdx-api'};
                $insert = $sql->insert($this->tableName);
                $insert->values($rowData);
                $stmt = $sql->prepareStatementForSqlObject($insert);
                $result = $stmt->execute();
            } else {
                /**
                 * @todo
                 * If record exist then do nothing. just skip this portation.
                 */
            }
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function isExists($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select($this->tableName)->where(array('cindex' => $id));
        $stmt = $sql->prepareStatementForSqlObject($select);
        return $stmt->execute()->count();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function active($id)
    {
        $sql = new Sql($this->dbAdapter);
        $update = $sql->update();
        $update->table($this->tableName);
        $update->set(
            array(
                'status' => (int)1
            )
        );
        $update->where(
            array(
                'cindex' => (string)$id
            )
        );

        $statement = $sql->prepareStatementForSqlObject($update);
        $results = $statement->execute();
        if ($results->getAffectedRows() == 1) {
            return true;
        }
        return false;

    }

    public function inActive($id)
    {
        $sql = new Sql($this->dbAdapter);
        $update = $sql->update();
        $update->table($this->tableName);
        $update->set(
            array(
                'status' => (int)1
            )
        );
        $update->where(
            array(
                'cindex' => (string)$id
            )
        );

        $statement = $sql->prepareStatementForSqlObject($update);
        $results = $statement->execute();
        if ($results->getAffectedRows() == 1) {
            return true;
        }
        return false;

    }

    /**
     * @param $id
     * @return mixed
     */
    public function inActivate($id)
    {
        $sql = new Sql($this->dbAdapter);
        $update = $sql->update();
        $update->table($this->tableName);
        $update->set(
            array(
                'status' => (int)0
            )
        );
        $update->where(
            array(
                'cindex' => (string)$id
            )
        );

        $statement = $sql->prepareStatementForSqlObject($update);
        $results = $statement->execute();
        if ($results->getAffectedRows() == 1) {
            return true;
        }
        return false;

    }

    public function activeAll()
    {
        $sql = new Sql($this->dbAdapter);
        $update = $sql->update();
        $update->table($this->tableName);
        $update->set(
            array(
                'status' => (int)1
            )
        );
        $update->where(
            array(
                '1' => 1
            )
        );

        $statement = $sql->prepareStatementForSqlObject($update);
        $results = $statement->execute();
        if ($results->getAffectedRows() >= 1) {
            return true;
        }
        return false;
    }

    public function inActiveAll()
    {
        $sql = new Sql($this->dbAdapter);
        $update = $sql->update();
        $update->table($this->tableName);
        $update->set(
            array(
                'status' => (int)0
            )
        );
        $update->where(
            array(
                '1' => 1
            )
        );

        $statement = $sql->prepareStatementForSqlObject($update);
        $results = $statement->execute();
        if ($results->getAffectedRows() >= 1) {
            return true;
        }
        return false;
    }

    public function importSample()
    {
        // TODO: Implement importSample() method.
    }

    public function createdBefore($timestamp)
    {
        // TODO: Implement createdBefore() method.
    }

    public function createdAfter($timestamp)
    {
        // TODO: Implement createdAfter() method.
    }

    public function createdBetween($fromTimestamp, $toTimestamp)
    {
        // TODO: Implement createdBetween() method.
    }

    public function updatedBefore($timestamp)
    {
        // TODO: Implement updatedBefore() method.
    }

    public function updatedAfter($timestamp)
    {
        // TODO: Implement updatedAfter() method.
    }

    public function updatedBetween($fromTimestamp, $toTimestamp)
    {
        // TODO: Implement updatedBetween() method.
    }


}