<?php

namespace AB\ReservationZenithBundle\Form;

use AB\ReservationZenithBundle\Entity\SpectacleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReservationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',null, array('label'=>'reservationTrad.nom'))
            ->add('prenom',null, array('label'=>'reservationTrad.prenom'))
            ->add('place',null, array('label'=>'reservationTrad.place'))
            ->add('seance',null, array('label'=>'seanceTrad.seance'))
            ->add('tarif',null, array('label'=>'tarifTrad.tarif',
                                     'disabled'=>'disabled'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AB\ReservationZenithBundle\Entity\Reservation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'reservation';
    }
}
