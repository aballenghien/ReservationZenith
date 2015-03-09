<?php
namespace AB\ReservationZenithBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AB\ReservationZenithBundle\Entity\Spectacle;
use AB\ReservationZenithBundle\Entity\Seance;
use AB\ReservationZenithBundle\Entity\Tarif;

class genererFluxRssCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('reservationzenith:genererRSS')
            ->setDescription('Générer le flux rss des spectacles')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $urlSource = 'http://localhost/UNIVERSITE/ReservationZenith/web/app_dev.php';
        $lignes = 0;
        $em = $this->getContainer()->get('doctrine')->getManager();
        $nomFile = 'fluxrss';
        $nomFile =$nomFile.".rss";
        if(file_exists($nomFile)){
            unlink($nomFile);
        }
        $file = fopen($nomFile, 'a');
        //entête xml
        fputs($file,'<?xml version="1.0" encoding="latin1"?>'."\n");
        //entête rss
        fputs($file,'<rss version="2.0">'."\n");
        //racine
        fputs($file,"\t".'<channel>'."\n");
        fputs($file,"\t"."\t".'<title>Liste des spectacles à venir</title>'."\n");
        fputs($file,"\t"."\t".'<link>'.$urlSource.$this->getContainer()->get('router')->generate('ab_reservation_zenith_homepage').'</link>'."\n");
        fputs($file,"\t"."\t".'<description>Affiche le liste des spectacle programmés pour cette année</description>'."\n");
        $output->writeln($nomFile);
        $listeSpectacles = $em->getRepository('ABReservationZenithBundle:Spectacle')->getSpectacleByDates(date('Y-m-d'), date('Y-m-d', strtotime('+1 year')));
        if(count($listeSpectacles) >0){
            foreach($listeSpectacles as $un_spectacle){
                fputs($file,"\t"."\t"."\t".'<item>'."\n");
                fputs($file,"\t"."\t"."\t"."\t".'<title>'.$un_spectacle['titre'].'</title>'."\n");
                fputs($file,"\t"."\t"."\t"."\t".'<description>'.$un_spectacle['commentaires'].'</description>'."\n");
                fputs($file,"\t"."\t"."\t"."\t".'<pubDate>'.date('Y-m-d').'</pubDate>'."\n");
                fputs($file,"\t"."\t"."\t"."\t".'<source>'.$urlSource.$this->getContainer()->get('router')->generate('voir_spectacle',array('id'=>$un_spectacle['id'])).'</source>'."\n");
                fputs($file,"\t"."\t"."\t".'</item>'."\n");
                $lignes++;
            }
        }
        fputs($file,"\t".'</channel>'."\n");
        fputs($file,'</rss>'."\n");
        fclose($file);
        if(file_exists($nomFile)){
            $output->writeln('Le fichier a ete genere avec succes, '.$lignes.' lignes ont ete ecrites');
        }else{
            $output->writeln('Erreur lors de l\'exportation');
        }
    }
}
?>