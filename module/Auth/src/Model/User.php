<?php
namespace Auth\Model;

class User
{
    public $id;
    public $email;
    public $password;
    public $firstname;
    public $surname;
    public $street;
    public $streetnumber;
    public $city;
    public $postcode;
    public $country;
    public $token;

    public function exchangeArray(array $data)
    { 
        $this->id           = !empty($data['id']) ? $data['id'] : null;
        $this->email        = !empty($data['email']) ? $data['email'] : null;
        $this->password     = !empty($data['password']) ? password_hash($data['password'], PASSWORD_DEFAULT) : null;
        $this->firstname    = !empty($data['firstname']) ? $data['firstname'] : null;
        $this->surname      = !empty($data['surname']) ? $data['surname'] : null;
        $this->street       = !empty($data['street']) ? $data['street'] : null;
        $this->streetnumber = !empty($data['streetnumber']) ? $data['streetnumber'] : null;
        $this->city         = !empty($data['city']) ? $data['city'] : null;
        $this->postcode     = !empty($data['postcode']) ? $data['postcode'] : null;
        $this->country      = !empty($data['country']) ? $data['country'] : null;
        $this->token        = !empty($data['token']) ? $data['token'] : null;
    }
}