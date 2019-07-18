<?php
namespace Application\ServiceFactory\Controller\Rest;

use Application\Controller\Rest\PhoneController;
use Application\Model\Phone;
use Application\Model\PhoneTable;
use Psr\Container\ContainerInterface;

class PhoneControllerFactory
{
    public function __invoke(ContainerInterface $Container)
    {
        $Container = $Container->getServiceLocator();
        $PhoneTable = $Container->get(PhoneTable::class);
        $Phone = new Phone();

        return new PhoneController($PhoneTable, $Phone);
    }
}