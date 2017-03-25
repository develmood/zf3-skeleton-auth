<?php
namespace Auth\Form;

use Zend\Form\Form;

class UserForm extends Form 
{
    public function __construct($name = null)
    {
        parent::__construct();

        $this
            ->add([
                'name' => 'token',
                'type' => 'hidden',
                'attributes' => [
                    'id' => 'token',
                    'value' => bin2hex(openssl_random_pseudo_bytes(16))
                ]
            ])
            ->add([
                'name' => 'id',
                'type' => 'hidden'
            ])
            ->add([
                'name' => 'email',
                'type' => 'text',
                'attributes' => [
                    'id' => 'email'
                ],
                'options' => [
                    'label' => 'E-Mail *'
                ]
            ])
             ->add([
                'name' => 'emailconfirm',
                'type' => 'text',
                'attributes' => [
                    'id' => 'emailconfirm',
                ],
                'options' => [
                    'label' => 'E-Mail confirm *'
                ]
            ])
            ->add([
                'name' => 'password',
                'type' => 'password',
                'attributes' => [
                    'id' => 'password',
                ],
                'options' => [
                    'label' => 'Password *'
                ]
            ]) 
            ->add([
                'name' => 'passwordconfirm',
                'type' => 'password',
                'attributes' => [
                    'id' => 'passwordconfirm',
                ],
                'options' => [
                    'label' => 'Password confirm *'
                ]
            ]) 
            ->add([
                'name' => 'firstname',
                'type' => 'text',
                'attributes' => [
                    'id' => 'firstname'
                ],
                'options' => [
                    'label' => 'First name'
                ]
            ])
            ->add([
                'name' => 'surname',
                'type' => 'text',
                'attributes' => [
                    'id' => 'surname'
                ],
                'options' => [
                    'label' => 'Surname'
                ]
            ])
            ->add([
                'name' => 'street',
                'type' => 'text',
                'attributes' => [
                    'id' => 'street'
                ],
                'options' => [
                    'label' => 'Street'
                ]
            ])
            ->add([
                'name' => 'streetnumber',
                'type' => 'text',
                'attributes' => [
                    'id' => 'streetnumber'
                ],
                'options' => [
                    'label' => 'Street number'
                ]
            ])
            ->add([
                'name' => 'city',
                'type' => 'text',
                'attributes' => [
                    'id' => 'city'
                ],
                'options' => [
                    'label' => 'City'
                ]
            ])
            ->add([
                'name' => 'postcode',
                'type' => 'text',
                'attributes' => [
                    'id' => 'postcode'
                ],
                'options' => [
                    'label' => 'Postcode'
                ]
            ])
            ->add([
                'name' => 'country',
                'type' => 'text',
                'attributes' => [
                    'id' => 'country'
                ],
                'options' => [
                    'label' => 'Country'
                ]
            ])
            ->add([
                'name' => 'submit',
                'type' => 'submit',
                'attributes' => [
                    'value' => 'Go',
                    'id' => 'submitbutton'
                ]
            ]);
    }
}