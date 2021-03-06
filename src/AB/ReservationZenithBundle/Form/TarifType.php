<?php

namespace AB\ReservationZenithBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TarifType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prix',null,array(
				'label'=> 'tarifTrad.prix' ))
			->add('numeroPlaceMin','integer',array('label'=>'tarifTrad.numeroPlaceMin'))
			->add('numeroPlaceMax','integer',array('label'=>'tarifTrad.numeroPlaceMax'));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AB\ReservationZenithBundle\Entity\Tarif'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tarif';
    }
}
