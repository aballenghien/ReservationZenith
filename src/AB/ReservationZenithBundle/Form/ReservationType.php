<?php

namespace AB\ReservationZenithBundle\Form;

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
        $t = $this->getContainer->get('translator');
        $builder
            ->add('nom', array('label'=>$t->trans('reservationTrad.nom')))
            ->add('prenom', array('label'=>$t->trans('reservationTrad.prenom')))
            ->add('place', array('label'=>$t->trans('reservationTrad.place')))
            ->add('seance', array('label'=>$t->trans('seanceTrad.seance')))
            ->add('tarif', array('label'=>$t->trans('tarifTrad.tarif')))
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
