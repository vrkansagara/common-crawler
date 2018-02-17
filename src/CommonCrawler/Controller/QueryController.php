<?php

namespace CommonCrawler\Controller;


use CommonCrawler\Service\QueryServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class QueryController extends AbstractActionController
{
    private $queryService;

    public function __construct(QueryServiceInterface $queryService)
    {
        $this->queryService = $queryService;
    }


    public function indexAction()
    {
        $status = $this->params()->fromRoute('status', null);
        switch ($status) {
            case '0':
                $queries = $this->queryService->findAllInactiveQueries();
                break;
            case '1':
                $queries = $this->queryService->findAllActiveQueries();
                break;
            default:
                $queries = $this->queryService->findAllQueries();
                break;
        }
        return new ViewModel(array(
            'queries' => $queries
        ));
    }

    public function insertAction()
    {
        $query = $this->params()->fromRoute('query', '*.co.uk');

//        $request = $this->getRequest(); //$request->isPost()
        if (!empty($query)) {
            $inserData = array(
                'query' => $query
            );
            $this->queryService->insertQuery($inserData);

        }

    }
}