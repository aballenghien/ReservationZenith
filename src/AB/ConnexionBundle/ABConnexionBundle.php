<?php

namespace AB\ConnexionBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ABConnexionBundle extends Bundle
{
	 public function getParent()
    {
        return 'FOSUserBundle';
    }
}
