<?php
namespace AB\ConnexionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ConnexionController extends Controller{
	public function connexionAction($page){
		$this->get('session')->set('pageprecedente', $page);
		return $this->redirect($this->get('router')->generate('fos_user_security_login'));
	}
}

?>