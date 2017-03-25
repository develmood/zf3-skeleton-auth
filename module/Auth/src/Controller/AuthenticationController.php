<?php
namespace Auth\Controller;

use RuntimeException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

use Auth\Model\User;
use Auth\Model\UserTable;
use Auth\Form\UserForm;
use Auth\Form\LoginFormFilter;
use Auth\Form\RegisterFormFilter;

class AuthenticationController extends AbstractActionController
{
    private $userTable;
    private $authService;

    public function __construct(UserTable $userTable, AuthenticationService $authService)
    {
        $this->userTable = $userTable;
        $this->authService = $authService;
    }

    public function indexAction() 
    {
        if(! $this->authService->hasIdentity()) {
            return $this->redirect()->toRoute( 'auth', ['action' => 'login'] );
        }
       
        return;
    }

    public function loginAction()
    {
        $request    = $this->getRequest();
        $form       = new UserForm();

        if(! $request->isPost()) {
            return ['form' => $form];
        }

        $filter = new LoginFormFilter();
        $form->setInputFilter($filter->getInputFilter());
        $form->setData($request->getPost());

        if(! $form->isValid()) {
            return ['form' => $form];
        }

        $formdata = $form->getData();

        $authAdapter = $this->authService->getAdapter();
        $authAdapter->setIdentity($formdata['email']);
        $authAdapter->setCredential($formdata['password']);

        $result = $this->authService->authenticate();

        if(! $result->isValid()) {
            echo '<pre>'; var_dump($result); die();
            return ['form' => $form];
        }

        $this->redirect()->toRoute('home');
    }

    public function registerAction()
    {
        $request    = $this->getRequest();
        $form       = new UserForm();

        if(! $request->isPost()) {
            return ['form' => $form];
        }

        $filter = new RegisterFormFilter();
        $form->setInputFilter($filter->getInputFilter());
        $form->setData($request->getPost());

        if(! $form->isValid()) {
            return ['form' => $form];
        }

        $formdata = $form->getData();

        $user = new User();
        $user->exchangeArray($formdata);

        // Save user in db
        try {
            $this->userTable->saveUser($user);
        } catch(RuntimeException $e) {
            // Error handling
            $error = $e->getPrevious()->errorInfo;
            return [
                'form' => $form,
                'errorType' => 'db',
                'errorCode' => $error[1],
                'errorMessage' => $error[2]
            ];
        }
        
        // @todo send confirmation mail with token
        // echo $formdata['token']; die();
        $this->redirect()->toRoute('auth', ['action' => 'login']);
    }

    public function logoutAction()
    {
        if($this->authService->hasIdentity()) {
            $this->authService->clearIdentity();
        }

        return $this->redirect()->toRoute('auth', ['action' => 'login']);
    }
}