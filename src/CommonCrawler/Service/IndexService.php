<?php

namespace CommonCrawler\Service;

use CommonCrawler\Mapper\IndexMapperInterface;
use CommonCrawler\Model\Index;
use Zend\Http\Client;

class IndexService implements IndexServiceInterface
{
    protected $indexMapper;

    /**
     * we successfully managed to keep the database-logic outside of our service.
     * Now we are able to implement different database solution depending on our need and change them easily when the time requires it.
     * IndexService constructor.
     * @param $indexMapper
     */
    public function __construct(IndexMapperInterface $indexMapper, array $configuration)
    {
        $this->indexMapper = $indexMapper;
    }

    public function findAllIndexes()
    {
        return $this->indexMapper->findAll();
    }

    public function findAllActiveIndexes()
    {
        return $this->indexMapper->findAllActive();
    }

    public function findAllInactiveIndexes()
    {
        return $this->indexMapper->findAllInactive();
    }

    public function findIndex($id)
    {
        return $this->indexMapper->find($id);
    }

    public function insertIndex(array $values)
    {
        $this->indexMapper->insert($values);
    }

    public function deleteIndex($id)
    {
        return $this->indexMapper->delete($id);
    }

    public function flushAllIndex()
    {
        return $this->indexMapper->flush();
    }

    public function importIndexFromServer()
    {
        return $this->indexMapper->import();
    }

    public function isIndexExists($id)
    {
        return $this->indexMapper->isExists($id);
    }

    public function activeIndex($id)
    {
        return $this->indexMapper->active($id);
    }

    public function inactiveIndex($id)
    {
        return $this->indexMapper->inActivate($id);
    }

    public function activeAllIndex()
    {
        return $this->indexMapper->activeAll();
    }

    public function inactiveAllIndex()
    {
        return $this->indexMapper->inactivateAll();
    }

    public function getPageSize(Index $index, $url, $output = 'json', $showNumPages = true)
    {
        $getParams = array(
            'url' => $url,
            'output' => $output,
            'pageSize' => 3,
            'filter' => '=status:200',
            'fl' => 'url',
        );

        if (isset($showNumPages)) {
            $getParams['showNumPages'] = $showNumPages;
        }
        $httpClient = new Client();
        $httpClient->setUri($index->getCdxApi());
        $httpClient->setParameterGet($getParams);
        if (!empty($httpClient->send()->getBody())) {
            $response = json_decode($httpClient->send()->getBody());
        } else {
            $message = 'Unable to fetch the index list.';
        }
        return $response;
    }

    private function generatePageSize(Index $index, $url)
    {
        /**
         * stdClass Object
         * (
         * [pages] => 3764
         * [pageSize] => 3
         * [blocks] => 11291
         */
        $pageResponse = $this->generatePageSize($index, $url);
        $pages = $pageResponse->pages;
        $pageSize = $pageResponse->pageSize;
        $blocks = $pageResponse->blocks;

        $paginationStart = 0;
        $paginationEnd = (int)($blocks / $pages) + 1;
        /**
         * @fixme halfway ......
         */
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

        for ($i = $paginationStart; $i <= $paginationEnd; $i++) {

        }
    }

}