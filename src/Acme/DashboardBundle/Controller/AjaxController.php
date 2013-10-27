<?php

namespace Acme\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\DashboardBundle\Entity\Qrcode;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
{

	public function getdataAction()
    {
		$repository = $this->getDoctrine()->getRepository('AcmeDashboardBundle:Qrcode');	
 
    	$codes = $repository->findAll();

    	$dataTable = array();
    	$i = 0;
    	$used =  0;
    	$unused = 0;

    	foreach ($codes as $code)
	    {
	       if($code->getUsed()){
	       		$used++;
	       }
	       else
	       {
				$unused++;
	       }

	       $dataTable[$i] = array($code->getSecret(), $code->getFilename(), !$code->getUsed(), $code->getWeight() );

	       $i++;
	    }

    	$chartData = array('used' => $used, 'unused' => $unused);

    	$response = array("chartData" => $chartData,
    					  "tableData" => $dataTable,
    		 			  "success" => true);


  		return new Response(json_encode($response)); 

    }


    public function sendMailAction(){

    	$JSONdata = json_decode($this->getRequest()->getContent(), true);
        $base_url = $this->getRequest()->getScheme() . '://' . $this->getRequest()->getHttpHost() . $this->getRequest()->getBasePath();

        $email = $JSONdata['email'];
        $filename = $JSONdata['filename'];


        $message = \Swift_Message::newInstance()
        ->setSubject('Loyalty code')
        ->setFrom('nikolic89@gmail.com')
        ->setTo($email)
        ->setBody("")
        ->addPart("<a href='" . $base_url . "/codes/" .$filename . "'>ViewCode</a>", 'text/html');

        $this->get('mailer')->send($message);

        $response = array('success' => true, 'email' => $email, 'filename' => $filename);


        return new Response(json_encode($response)); 

    }



}