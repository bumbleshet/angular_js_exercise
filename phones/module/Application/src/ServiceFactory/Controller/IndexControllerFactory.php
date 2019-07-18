<?php
namespace Application\ServiceFactory\Controller;

use Application\Controller\IndexController;
use Application\Model\PhoneTable;
use Application\Service\PhoneService;
use Psr\Container\ContainerInterface;

class IndexControllerFactory
{
    public function __invoke(ContainerInterface $Container)
    {
        $Container = $Container->getServiceLocator();
        $PhoneTable = $Container->get(PhoneTable::class);
        $PhoneService = $Container->get(PhoneService::class);

        return new IndexController($PhoneTable, $PhoneService);
    }
}