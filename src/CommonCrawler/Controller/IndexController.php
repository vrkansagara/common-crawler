<?php

namespace CommonCrawler\Controller;

use CommonCrawler\Form\IndexForm;
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
        $status = $this->params()->fromRoute('status', null);
        switch ($status) {
            case '0':
                $indexes = $this->indexService->findAllInactiveIndexes();
                break;
            case '1':
                $indexes = $this->indexService->findAllActiveIndexes();
                break;
            default:
                $indexes = $this->indexService->findAllIndexes();
                break;
        }
        return new ViewModel(array(
            'indexes' => $indexes
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

    public function activeIndexAction()
    {
        $indexId = $this->params()->fromRoute('id', null);
        $this->indexService->activeIndex($indexId);
        $this->flashMessenger()->addSuccessMessage('Index activated');
        /**@todo redirect to backroute with filter value(s) */
        return $this->redirect()->toRoute('commoncrawler');
    }

    public function inActiveIndexAction()
    {
        $indexId = $this->params()->fromRoute('id', null);
        $this->indexService->inactiveIndex($indexId);
        $this->flashMessenger()->addSuccessMessage('Index Inactivated');
        /**@todo redirect to backroute with filter value(s) */
        return $this->redirect()->toRoute('commoncrawler');
    }

    public function editAction()
    {
        $indexId = $this->params()->fromRoute('id', null);
        if (!$indexId) {
            $this->flashMessenger()->addErrorMessage('Provide Index id.');
            return $this->redirect()->toRoute('commoncrawler', array(
                'action' => 'index'
            ));
        }

        try {
            $index = $this->indexService->findIndex($indexId);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('commoncrawler', array(
                'action' => 'index'
            ));
        }

        $form = new IndexForm();
        $form->bind($index);
        $form->get('submit')->setAttribute('value', 'Update');

//        $request = $this->getRequest();
//        if ($request->isPost()) {
//            $form->setInputFilter($index->getInputFilter());
//            $form->setData($request->getPost());
//
//            if ($form->isValid()) {
//                $this->getTodoTable()->saveTodo($Todo);
//
//                // Redirect to list of Todos
//                return $this->redirect()->toRoute('todo');
//            }else{
//                /**
//                 * @todo invalid form show proper notification.
//                 */
//            }
//        }

        return array(
            'id' => $indexId,
            'form' => $form,
        );
    }
}