<?php
namespace Auth;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use Auth\Service\AuthenticationService;
use Zend\ModuleManager\ModuleManager;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\UserTable::class => function($container) {
                    $tableGateway = $container->get(Model\UserTableGateway::class);
                    return new Model\UserTable($tableGateway);
                },
                Model\UserTableGateway::class => function($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\User());
                    return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                }
            ]
        ];
    }

    /**
     *  If user is not logged in, then redirect to login page
     */
    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $auth = $app->getServiceManager()->get(AuthenticationService::class);
        
        if(! $auth->hasIdentity()) {
            $em = $app->getEventManager();
            $em->attach(MvcEvent::EVENT_ROUTE, function($e) {

                $match = $e->getRouteMatch();
                
                if($match->getMatchedRouteName() != 'auth') {
                    $router = $e->getRouter();
                    $url = $router->assemble(['action' => 'login'], ['name' => 'auth']);

                    $response = $e->getResponse();
                    $response->getHeaders()
                        ->addHeaderLine('Location', $url);
                    $response->setStatusCode(302);

                    return $response;
                }
            }, -100);
        }
    }

    /**
     *  Change layout for this module
     */
    public function init(ModuleManager $m) 
    {
        $events = $m->getEventManager();
        $sharedEvents = $events->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
            $controller = $e->getTarget();
            if(get_class($controller) == Controller\AuthenticationController::class) {
                $controller->layout('layout/auth');
            }
        });
    }
}