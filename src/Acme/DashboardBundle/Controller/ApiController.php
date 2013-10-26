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

 	public function showQrcodeAction($secret)
    {

    	$response = array();

	    $em = $this->getDoctrine()->getManager();
	    $code = $em->getRepository('AcmeDashboardBundle:Qrcode')->findOneBy(array( 'secret' => $secret));

	    if (!$code) {
	       $response = array('success' => false,
 				  'secret' => $secret,
 				  'code' => null,
 				  'image_path' => null,
 				  'error' => 'No code found for secret = '.$secret 
 			);
	    }
	    elseif($code->getUsed()){
	    	$response = array('success' => false,
 				  'secret' => $secret,
 				  'code' => $code->toArray(),
 				  'image_path' => "http://localhost:8000/codes/" . $code->getFilename(),
 				  'error' => 'Already used.' 
 			);	
	    }
	    else
	    {

	    	$response = array('success' => true,
 				  'secret' => $secret,
 				  'code'=> $code->toArray(),
 				  'image_path' => "http://localhost:8000/codes/" . $code->getFilename(),
 				  'error' => null
 				);
	    }

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
	    elseif($code->getUsed()){
	    	$response = array('success' => false,
 				  'secret' => $secret,
 				  'code' => $code->toArray(),
 				  'error' => 'Already used.' 
 			);	
	    }
	    else
	    {
	    	$code->setUsed(true);
	    	$code->setUpdated(new \DateTime("now"));
	    	$em->flush();

	    	$response = array('success' => true,
 				  'secret' => $secret,
 				  'code'=> $code->toArray(),
 				  'error' => null
 				);

	    }

  		return new Response(json_encode($response)); 
    }

}