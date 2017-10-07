<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/7
 * Time: 13:01
 */

namespace EShine\Controller;


use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;
use Slim\Views\PhpRenderer;

abstract class BaseController
{
    /**
     * @var Router
     */
    public $router;

    /**
     * @var PhpRenderer
     */
    public $renderer;


    /**
     * @var Logger
     */
    public $logger;

    /**
     * @var Container;
     */
    public $container;

    /**
     * SlimActionBass constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->setDependByContainer();
    }

    public function setDependByContainer()
    {
        $depends = $this->getDepends($this);
        foreach ($depends as $dependName => $depend) {
            $this->initDependByName($dependName);
        }
    }

    public function getDepends($obj)
    {
        $getPublicProps =  create_function('$obj', 'return get_object_vars($obj);');
        return $getPublicProps($obj);
    }

    public function initDependByName($name)
    {
        try {
            $this->{$name} = $this->container->get($name);
        } catch (\Exception $e) {
            unset($this->{$name});
        }
    }

    public function getReferenceUrl()
    {
        return $_SERVER['HTTP_REFERER'];
    }


    /**
     * @param Request $request
     * @param Response $response
     * @param $args array
     * @return mixed
     */
    abstract public function __invoke(Request $request, Response $response, array $args);
}