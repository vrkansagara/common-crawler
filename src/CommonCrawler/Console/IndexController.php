<?php

namespace CommonCrawl\Console;

use CommonCrawl\Service\IndexServiceInterface;
use Zend\Console\ColorInterface as Color;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Text\Table\Column;
use Zend\Text\Table\Row;
use Zend\Text\Table\Table;

class IndexController extends AbstractActionController
{
    protected $indexId;
    protected $console;
    protected $config;
    protected $defaultOptions = array(
        'ping' => true,
        'list' => false,
        'insert' => false,
        'verbose' => false,
        'flush' => false,
        'active' => false,
        'inactive' => false,
        'active-all' => false,
        'inactive-all' => false,
    );

    private $consoleWidth;

    private $indexService;

    public function __construct(IndexServiceInterface $indexService)
    {
        $this->indexService = $indexService;
    }

    public function indexAction()
    {
        $flags = $this->getFlags();
        $console = $this->setConsole();
        if ($flags['list']) {
            $this->fetchAllIndexs();
        } elseif ($flags['insert']) {
            $this->insertIndexes();
        } elseif ($flags['flush']) {
            $this->flushIndexes();
        } elseif ($flags['active']) {
            $this->activeIndex($this->indexId);
        } elseif ($flags['inactive']) {
            $this->inactiveIndex($this->indexId);
        } elseif ($flags['active-all']) {
            $this->activeAllIndex();
        } elseif ($flags['inactive-all']) {
            $this->inactiveAllIndex();
        } else {
            $message = 'Ping working..';
            $this->console->write($message, Color::BLUE);
            $this->reportDone($this->consoleWidth, strlen($message));
        }
    }

    public function getFlags()
    {
        $request = $this->getRequest();
        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can only use this action from a console!');
        }
        $options = $this->params()->fromRoute();
        $this->indexId = $this->params()->fromRoute('indexid', null);

        $test = array(
            array('long' => 'ping', 'short' => 'p'),
            array('long' => 'list', 'short' => 'l'),
            array('long' => 'insert', 'short' => 'i'),
            array('long' => 'verbose', 'short' => 'v'),
            array('long' => 'flush', 'short' => 'f'),
            array('long' => 'active', 'short' => 'a'),
            array('long' => 'inactive', 'short' => 'in'),
            array('long' => 'active-all', 'short' => 'al'),
            array('long' => 'inactive-all', 'short' => 'inl'),
        );
        foreach ($test as $spec) {
            $long = $spec['long'];
            $short = $spec['short'];
            if ((!isset($options[$long]) || !$options[$long])
                && (isset($options[$short]) && $options[$short])
            ) {
                $options[$long] = true;
                unset($options[$short]);
            }
        }
        $options = array_merge($this->defaultOptions, $options);
        if (
            $options['list']
            || $options['verbose']
            || $options['insert']
            || $options['flush']
            || $options['active']
            || $options['inactive']
            || $options['active-all']
            || $options['inactive-all']
        ) {
            $options['ping'] = false;
        }

        return $options;
    }

    public function setConsole()
    {
        $sm = $this->getServiceLocator();
        $this->console = $sm->get('Console');
        $this->consoleWidth = $this->console->getWidth();
    }

    /**
     * @todo Improve console width with dynamic column size.
     */
    private function fetchAllIndexs()
    {
        $result = $this->indexService->findAllIndexes();

        $table = new Table(array('columnWidths' => array(5, 20, 30, 40, 60, 5)));
        $table->appendRow(array('#', 'Index name', 'timegate', 'cdx-api', 'status'));

        $rows = array();
        foreach ($result as $k => $index) {
            $row = new Row();
            $row->appendColumn(new Column((string)++$k));
            $row->appendColumn(new Column((string)$index->getIndex()));
            $row->appendColumn(new Column((string)$index->getName()));
            $row->appendColumn(new Column((string)$index->getTimegate()));
            $row->appendColumn(new Column((string)$index->getCdxApi()));
            $row->appendColumn(new Column((string)$index->getStatus()));
            $table->appendRow($row);
        }
        echo $table;
    }

    /**
     * @todo
     *  (1) Improve error message flow.
     * @fixme
     */
    public function insertIndexes()
    {
        $this->indexService->importIndexFromServer();
        $message = 'All indexes are imported.';
        $this->console->write($message, Color::BLUE) . PHP_EOL;
        $this->reportDone($this->consoleWidth, strlen($message));

    }

    protected function reportDone($width, $used, $success = true)
    {
        if (($used + 8) > $width) {
            $this->console->writeLine('');
            $used = 0;
        }
        if ($success) {
            $spaces = $width - $used - 8;
            $this->console->writeLine(str_repeat('.', $spaces) . '[ DONE ]', Color::GREEN);
        } else {
            $spaces = $width - $used - 10;
            $this->console->writeLine(str_repeat('.', $spaces) . '[ CANCLE ]', Color::RED);
        }
    }

    public function flushIndexes()
    {
        $this->indexService->flushAllIndex();
        $message = 'All indexes are deleted.';
        $this->console->write($message, Color::RED) . PHP_EOL;
        $this->reportDone($this->consoleWidth, strlen($message));
    }

    public function activeIndex($id)
    {
        $result = $this->indexService->activeIndex($id);
        if ($result) {
            $message = sprintf('%s%s', $id, ' is active.');
            $this->console->write($message, Color::LIGHT_GREEN) . PHP_EOL;
        } else {
            $message = sprintf('%s%s', $id, ' INDEX already activated.');
            $this->console->write($message, Color::GREEN) . PHP_EOL;
        }


        $this->reportDone($this->consoleWidth, strlen($message));
    }

    public function inactiveIndex($id)
    {
        $result = $this->indexService->inactiveIndex($id);
        if ($result) {
            $message = sprintf('%s%s', $id, ' is inactived.');
            $this->console->write($message, Color::LIGHT_GREEN) . PHP_EOL;
        } else {
            $message = sprintf('%s%s', $id, ' INDEX already inactive.');
            $this->console->write($message, Color::GREEN) . PHP_EOL;
        }
    }

    public function activeAllIndex()
    {
        $result = $this->indexService->activeAllIndex();
        if ($result) {
            $message = sprintf('%s', 'All index are inactivated.');
            $this->console->write($message, Color::LIGHT_GREEN) . PHP_EOL;
        } else {
            $message = sprintf('%s', 'All index are inactivated.');
            $this->console->write($message, Color::GREEN) . PHP_EOL;
        }


        $this->reportDone($this->consoleWidth, strlen($message));
    }

    public function inactiveAllIndex()
    {
        $result = $this->indexService->inactiveAllIndex();
        if ($result) {
            $message = sprintf('%s', 'All index are inactivated.');
            $this->console->write($message, Color::LIGHT_GREEN) . PHP_EOL;
        } else {
            $message = sprintf('%s', 'All index are inactivated.');
            $this->console->write($message, Color::GREEN) . PHP_EOL;
        }
    }

    public function setConfig()
    {
        $sm = $this->getServiceLocator();
        $this->config = $sm->get('Config');
    }
}