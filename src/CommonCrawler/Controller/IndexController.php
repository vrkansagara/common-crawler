<?php

namespace CommonCrawler\Controller;

use CommonCrawler\Service\IndexServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private $indexService;

    public function __construct(IndexServiceInterface $indexService)
    {
        $this->indexService = $indexService;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'indexes' => $this->indexService->findAllIndexes()
        ));
    }

    public function deleteAllAction()
    {
        $this->indexService->flushAllIndex();
        $this->flashMessenger()->addSuccessMessage('All indexes are removed.');
        return $this->redirect()->toRoute('commoncrawler');

    }

    public function importAction()
    {
        $this->indexService->importIndexFromServer();
        $this->flashMessenger()->addSuccessMessage('All indexes are imported.');
        return $this->redirect()->toRoute('commoncrawler');
    }

    public function showAction()
    {
        $indexId = (string)$this->params()->fromRoute('index');
        $index = $this->indexService->findIndex($indexId);
        $this->indexService->getPageSize($index, '*.co.uk');
    }

    public function generatePagesAction()
    {
        $indexId = (string)$this->params()->fromRoute('index', '');
        $url = (string)$this->params()->fromRoute('url', '');
        $index = $this->indexService->findIndex($indexId);
        $this->indexService->getPageSize($index, $url);
    }
}