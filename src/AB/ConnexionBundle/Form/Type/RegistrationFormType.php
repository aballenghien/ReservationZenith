<?php

namespace AB\ConnexionBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('nom');
        $builder->add('prenom');
        $builder->add('adresse');
    }

    public function getName()
    {
        return 'ab_connexion_registration';
    }
}

?>