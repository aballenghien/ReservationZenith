<?php

namespace AB\ConnexionBundleBundle\Form;

use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'myapp_user_registration';
    }
}