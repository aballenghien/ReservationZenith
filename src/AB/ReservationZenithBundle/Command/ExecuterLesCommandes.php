<?php
	namespace AB\ReservationZenithBundle\Command;
	use Symfony\Bundle\FrameworkBundle\Console\Application;
	use Symfony\Component\Console\Input\ArrayInput;
	use Symfony\Component\Console\Output\NullOutput;

	class ExecuterLesCommandes {
		public static function runCommand($command, $controller, $arguments = array())
		{
		    $kernel = $controller->get('kernel');
		    $app = new Application($kernel);

		    $args = array_merge(array('command' => $command), $arguments);

		    $input = new ArrayInput($args);
		    $output = new NullOutput();

		    return $app->doRun($input, $output);
		}
	}

?>