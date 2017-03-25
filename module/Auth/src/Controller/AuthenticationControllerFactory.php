<?php
namespace Auth\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Auth\Service\AuthenticationService;
// use User\Service\MailService;
use Auth\Model\UserTable;

class AuthenticationControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userTable      = $container->get(UserTable::class);
        $authService    = $container->get(AuthenticationService::class);
        // $mailService    = $container->get(MailService::class);

        // return new UserController($userTable, $authService, $mailService);
        return new AuthenticationController($userTable, $authService);
    }
}