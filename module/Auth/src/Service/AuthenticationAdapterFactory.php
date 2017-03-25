<?php 
namespace Auth\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Db\Adapter\Adapter;

class AuthenticationAdapterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');
        $dbAdapter = new Adapter($config['db']);
        
        return new AuthenticationAdapter($dbAdapter);
    }
}