<?php
namespace Application\ServiceFactory\Model;


use Application\Model\PhoneTable;
use Psr\Container\ContainerInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class PhoneTableFactory
{
    public function __invoke(ContainerInterface $Container)
    {
        $DbAdapter = $Container->get('rest_apiv2');
        $ResultSetPrototype = new ResultSet();

        $PhonesTableGateway = new TableGateway(
            'phones',
            $DbAdapter,
            null,
            $ResultSetPrototype
        );
        return new PhoneTable($PhonesTableGateway);
    }
}

