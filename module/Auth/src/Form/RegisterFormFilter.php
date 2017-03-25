<?php
namespace Auth\Form;

use DomainException;
use Zend\Filter\StripTags;
use Zend\Filter\StringTrim;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;

class RegisterFormFilter implements InputFilterAwareInterface
{
    private $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class
                ],[
                    'name' => EmailAddress::class
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'emailconfirm',
            'required' => true,
            'filters'   => [
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class
                ],[
                    'name' => Identical::class,
                    'options' => [
                        'token' => 'email'
                    ]
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'password',
            'required' => true,
            'filters'   => [
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class
                ],[
                    'name' => StringLength::class,
                    'options' => [
                        'min' => 6,
                        'max' => 128
                    ]
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'passwordconfirm',
            'required' => true,
            'filters'   => [
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class
                ],[
                    'name' => Identical::class,
                    'options' => [
                        'token' => 'password'
                    ]
                ]
            ]
        ]);

        $inputFilter->add([
            'name' => 'firstname',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ]
        ]);

        $inputFilter->add([
            'name' => 'surname',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ]
        ]);

        $inputFilter->add([
            'name' => 'street',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ]
        ]);

        $inputFilter->add([
            'name' => 'streetnumber',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ]
        ]);

        $inputFilter->add([
            'name' => 'city',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ]
        ]);

        $inputFilter->add([
            'name' => 'postcode',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ]
        ]);

        $inputFilter->add([
            'name' => 'country',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class]
            ]
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}