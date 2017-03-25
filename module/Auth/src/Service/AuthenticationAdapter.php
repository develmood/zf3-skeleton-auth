<?php
namespace Auth\Service;

use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter;
use Zend\Authentication\Adapter\AdapterInterface;

class AuthenticationAdapter extends CallbackCheckAdapter implements AdapterInterface
{
    private $dbAdapter;

    public function __construct($dbAdapter) 
    {   
        $passwordValidation = function($hash, $password) {
            return password_verify($password, $hash);
        };

        parent::__construct(
            $dbAdapter, 
            'user',
            'email',
            'password',
            $passwordValidation
        );
    }
}