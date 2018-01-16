<?php

namespace CommonCrawl\Mapper;

use CommonCrawl\Model\IndexInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Http\Client;
use Zend\Stdlib\Hydrator\HydratorInterface;


class ZendDbSqlMapper implements IndexMapperInterface
{
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

    private $configuration;

    public function __construct(
        AdapterInterface $dbAdapter,
        HydratorInterface $hydrator,
        IndexInterface $indexPrototype,
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
        $select = $sql->select('common_index');
        $select->where(array("index" => $id));

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
        $option = $this->configuration['CommonCrawl']['options'];
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
                $rowData['index'] = $row->id;
                $this->active($row->id);
                $rowData['name'] = $row->name;
                $rowData['timegate'] = $row->timegate;
                $rowData['cdx_api'] = $row->{'cdx-api'};
                $insert = $sql->insert('common_index');
                $insert->values($rowData);
                $stmt = $sql->prepareStatementForSqlObject($insert);
                $result = $stmt->execute();
                $this->active($row->id);
            } else {
                $this->active($row->id);
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
        $select = $sql->select('common_index')->where(array('index' => $id));
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
        $update->table('common_index');
        $update->set(
            array(
                'status' => (int)1
            )
        );
        $update->where(
            array(
                'index' => (string)$id
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
        $update->table('common_index');
        $update->set(
            array(
                'status' => (int)0
            )
        );
        $update->where(
            array(
                'index' => (string)$id
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
        $update->table('common_index');
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

    public function inactivateAll()
    {
        $sql = new Sql($this->dbAdapter);
        $update = $sql->update();
        $update->table('common_index');
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


}