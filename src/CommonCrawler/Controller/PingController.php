<?php

namespace CommonCrawl;

use Zend\Mvc\Controller\AbstractActionController;

class PingController extends AbstractActionController
{

    public function ping()
    {
        return 'true';
    }
}