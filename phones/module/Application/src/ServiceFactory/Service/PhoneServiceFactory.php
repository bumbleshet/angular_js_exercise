<?php
namespace Application\ServiceFactory\Service;

use Application\Service\PhoneService;
use Psr\Container\ContainerInterface;

class PhoneServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new PhoneService();
    }
}