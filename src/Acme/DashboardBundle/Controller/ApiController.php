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



    	
    	$response = array('success' => true, 'secret' => $secret);

  		return new Response(json_encode($response)); 
    }  

}