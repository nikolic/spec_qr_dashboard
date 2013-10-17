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

	       $dataTable[$i] = array($code->getSecret(), $code->getFilename(), !$code->getUsed(), 4 );

	       $i++;
	    }

    	$chartData = array('used' => $used, 'unused' => $unused);

    	$response = array("chartData" => $chartData,
    					  "tableData" => $dataTable,
    		 			  "success" => true);


  		return new Response(json_encode($response)); 

    }

}