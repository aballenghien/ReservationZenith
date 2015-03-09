<?php

namespace AB\ReservationZenithBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SeanceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tabAnnees = array();
        $annee = date("Y");
        for($i = $annee; $i <= $annee+5; $i++){
            $tabAnnees[] = $i;
        }
        $heureOuverture = 15;
        $heureFermeture = 24;

        $tabHeures =  array();
        for($i = $heureOuverture; $i<=$heureFermeture; $i++){
            $tabHeures[] = $i;
        }
        $builder
            ->add('heure','time',array(
                'label'=>'seanceTrad.heure',
                'widget'=>'choice',
                'empty_value'=>array(
                                    'hour'=>'heure',
                                    'minute'=>'minute'),
                'hours'=>$tabHeures))
            ->add('date','date',array(
                'label'=>'seanceTrad.date',
                'widget'=>'choice',
                'empty_value'=>array(
                                    'year'=>'Année',
                                    'month'=>'Mois',
                                    'day'=>'Jour'),
                'years'=>$tabAnnees))
            ->add('nombrePlacesRestantes',null,array('label'=>'seanceTrad.nbPlacesRestantes'));
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AB\ReservationZenithBundle\Entity\Seance'
        ));
    }





    /**
     * @return string
     */
    public function getName()
    {
        return 'seance';
    }
}
