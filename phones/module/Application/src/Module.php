<?php
namespace Application;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $EventManager        = $e->getApplication()->getEventManager();
        $ModuleRouteListener = new ModuleRouteListener();
        $ModuleRouteListener->attach($EventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function setEventManager(EventManagerInterface $events)
    {
        $this->events = $events;
        // Register a listener at high priority
        $events->attach('dispatch', array($this, 'checkOptions'), 10);
    }
}
