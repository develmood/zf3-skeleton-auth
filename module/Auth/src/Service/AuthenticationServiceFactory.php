<?php 
namespace Auth\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Service\SessionManager; 
use Auth\Service\AuthenticationAdapter;

class AuthenticationServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $sessionManager     = $container->get(SessionManager::class);
        $authStorage        = new SessionStorage('Auth', 'session', $sessionManager);
        $authAdapter        = $container->get(AuthenticationAdapter::class);

        return new AuthenticationService($authStorage, $authAdapter);
    }
}