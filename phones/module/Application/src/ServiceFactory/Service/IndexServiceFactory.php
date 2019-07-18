<?php
namespace Application\ServiceFactory\Service;

use Application\Service\IndexService;
use Psr\Container\ContainerInterface;

class IndexServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new IndexService();
    }
}