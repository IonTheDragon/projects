<?php
// src/Controller/GeodataController.php
namespace App\Controller;
use App\Entity\Ip;
use App\Entity\Geodata;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query;

class GeodataController extends AbstractController
{
    /**
     * @Route("/ipform")
    */    
    
    public function ipform(Request $request)
    {
		$data = "";
        $ip = new Ip();
        $entityManager = $this->getDoctrine()->getManager();
        $rows = "Top 10 queries:<br>";

		$form = $this->createFormBuilder($ip)
    	    ->add('ip', TextType::class)
    	    ->add('save', SubmitType::class, ['label' => 'Send Ip'])
    	    ->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
    	    
    	    $ip = $form->getData()->getIp();
			$uri = 'https://api.2ip.ua/geo.json?ip='.$ip;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $uri);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$response = curl_exec($ch);
			$regexp = "/IP address is not valid/u";
			$regexplim = "/Limit of returned objects has been reached/u";
			$match = [];

			if (preg_match($regexp, $response, $match)) {
				$data = "IP address is not valid<br><br>";
			} elseif (preg_match($regexplim, $response, $match)) {
				$data = "Limit of ip validations has been reached (but it seems your ip is valid)<br><br>";
			} else {
				$arr = (array)(json_decode($response));
				$country = $arr['country'];
				$city = $arr['city'];
				$data = "Got country: ".$country.", city: ".$city."<br><br>";
				$datetime = new \DateTime(null, new \DateTimeZone('Europe/Moscow'));
				$fdatetime = $datetime->format('Y-m-d H:i:sP');

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
		
		$query = $entityManager->createQuery(
			'SELECT u
			FROM App\Entity\Geodata u
			'
		)->setMaxResults(10);
		
		$arr = $query->getResult();
		foreach ($arr as $value) {
			$rows .= $value->getIp().", ".$value->getCountry().", ".$value->getCity()."<br>";
		}

		return $this->render('ip/ipform.html.twig', [
    	    'form' => $form->createView(), 'answer' => $data, 'rows' => $rows
		]);
    }
}
