<?php

namespace AB\ReservationZenithBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SpectacleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $dureeMin = 30;
        $dureeMax = 240;
        $tabDurees = array();
        for($i = $dureeMin;$i <= $dureeMax; $i++){
            $tabDurees[] = $i;
        }
        $builder
            ->add('titre',null,array('label'=>'spectacleTrad.titre'))
            ->add('genre',null,array('label'=>'spectacleTrad.genre'))
            ->add('duree','integer', array(
                'label'=>'spectacleTrad.duree'))
            ->add('nombreDePlaces',null,array('label'=>'spectacleTrad.nbPlaces'))
            ->add('commentaires',null,array('label'=>'spectacleTrad.commentaires'))
            ->add('affiche',null,array('label'=>'spectacleTrad.affiche'))
            ->add('seances','collection', array(
            'type'=>new SeanceType(),
            'allow_add'=>true,
            'allow_delete'=>true,
            'by_reference'=>false))
            ->add('tarifs','collection', array(
            'type'=>new TarifType(),
            'allow_add'=>true,
            'allow_delete'=>true,
            'by_reference'=>false))
            ;
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AB\ReservationZenithBundle\Entity\Spectacle'
        ));
    }

    

    /**
     * @return string
     */
    public function getName()
    {
        return 'spectacle';
    }
}
