<?php

namespace Acme\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\DashboardBundle\Entity\Qrcode;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{

	public function pingAction()
    {

    	$response = array('pong' => true);

  		return new Response(json_encode($response)); 
    }  

 	public function updateQrcodeAction($secret)
    {

    	$response = array();

	    $em = $this->getDoctrine()->getManager();
	    $code = $em->getRepository('AcmeDashboardBundle:Qrcode')->findOneBy(array( 'secret' => $secret));

	    if (!$code) {
	       $response = array('success' => false,
 				  'secret' => $secret,
 				  'code' => null,
 				  'error' => 'No code found for secret = '.$secret 
 			);
	    }
	    else
	    {
	    	$code->setUsed(true);
	    	$code->setUpdated(new \DateTime("now"));
	    	$em->flush();

	    	$response = array('success' => true,
 				  'secret' => $secret,
 				  'code'=> array('id' => $code->getId(),
 				  				 'weight' =>  $code->getWeight(),
 				  				 'used' => $code->getUsed(),
 				  				 'secret' => $code->getSecret(),
 				  				 'created' => $code->getCreated()->format('Y-m-d H:i:s'),
 				  				 'updated' => $code->getUpdated()->format('Y-m-d H:i:s'),
 				  				 'filename' => $code->getFilename(),
 				  				 'user' => $code->getUser()
 				  				 ),
 				  'error' => null
 				);

	    }

  		return new Response(json_encode($response)); 
    }  

}