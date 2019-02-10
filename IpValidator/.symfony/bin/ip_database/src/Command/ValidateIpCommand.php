<?php
namespace App\Command;
use App\Entity\Geodata;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query;

class ValidateIpCommand extends ContainerAwareCommand
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'validate-ip';

    protected function configure()
    {
		$this
    	    // the short description shown while running "php bin/console list"
    	    ->setDescription('Validate and add in database ip data')

    	    // the full command description shown when running the command with
    	    // the "--help" option
    	    ->setHelp('Type ip to validate it')
			->addArgument('ip', InputArgument::REQUIRED, 'IP')
		;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {	
		$ip = $input->getArgument('ip');
		$regexp = "/IP address is not valid/u";
		$regexplim = "/Limit of returned objects has been reached/u";
		$match = [];
		$response="";
		$datetime = new \DateTime(null, new \DateTimeZone('Europe/Moscow'));
		$fdatetime = $datetime->format('Y-m-d H:i:sP');
		$entityManager = $this->getContainer()->get('doctrine')->getManager();
						
		if ($ip!="validate_existed") {
    	    
			$uri = 'https://api.2ip.ua/geo.json?ip='.$ip;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $uri);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$response = curl_exec($ch);			

			if (preg_match($regexp, $response, $match)) {
				$data = "IP address is not valid";
				$output->writeln($data);
			} elseif (preg_match($regexplim, $response, $match)) {
				$data = "Limit of ip validations has been reached (but it seems your ip is valid)";
				$output->writeln($data);
			} else {
				$arr = (array)(json_decode($response));
				$country = $arr['country'];
				$city = $arr['city'];
				$data = "Got country: ".$country.", city: ".$city;
				$output->writeln($data);
				$exdata = $entityManager->getRepository(Geodata::class)->find($ip);
				if (!$exdata) {
					$geodata = new Geodata();
					$geodata->setIp($ip);
					$geodata->setCountry($country);
					$geodata->setCity($city);
					$geodata->setDatetime($fdatetime);
					$entityManager->persist($geodata);
				}
				else {
					$exdata->setCountry($country);
					$exdata->setCity($city);
					$exdata->setDatetime($fdatetime);
				}
				$entityManager->flush();
											
			}
		}
		
		if (preg_match($regexplim, $response, $match)) {
			$output->writeln("Aborting");
		}
		else {
			//Check existed ip's
			$output->writeln("Validating existed data");
			$query = $entityManager->createQuery(
				'SELECT u
				FROM App\Entity\Geodata u
				'
			);		
			$data_array = $query->getResult();
			foreach ($data_array as $value) {

				$row_ip = $value->getIp();
				$uri = 'https://api.2ip.ua/geo.json?ip='.$row_ip;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $uri);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

				$response = curl_exec($ch);	
													
				if (preg_match($regexp, $response, $match)) {
					$data = "IP address ".$row_ip." is not valid";
					$output->writeln($data);
				} elseif (preg_match($regexplim, $response, $match)) {
					$data = "Limit of ip validations has been reached (but it seems your ip is valid)";
					$output->writeln($data);
					break;
				} else {
					$arr = (array)(json_decode($response));
					$country = $arr['country'];
					$city = $arr['city'];
					$exdata = $entityManager->getRepository(Geodata::class)->find($row_ip);
					$exdata->setCountry($country);
					$exdata->setCity($city);
					$exdata->setDatetime($fdatetime);
					$data = "Updated Ip:".$row_ip.", country: ".$country.", city: ".$city;
					$output->writeln($data);
					$entityManager->flush();					
				}		
			}							
			$output->writeln("Completed");
		}
    }
}
