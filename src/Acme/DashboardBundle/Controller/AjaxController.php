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

    	$used =  0;
    	$unused = 0;

    	//for($i = 0; $i < count($codes); $i++){
    	//	$used += $code[0]->id;
    	//}

    	$dataTable = array();
    	$i = 0;


    	foreach ($codes as $code)
	    {
	       if($code->getUsed()){
	       	$used++;
	       }
	       else{
	       	$unused++;
	       }
	       $dataTable[$i] = array($code->getSecret(), $code->getFilename(), $code->getUsed(), 4 );

	       $i++;
	    }

    	// $dataTable = array(array("9d93hh47274","filename.png", true , 5 ),
    	// 					array("122123132","f4.png", false , 1 )
    	// 	);

    	$chartData = array('used' => $used, 'unused' => $unused);

    	$response = array("chartData" => $chartData,
    					  "tableData" => $dataTable,
    		 			  "success" => true);
  			//you can return result as JSON
  		return new Response(json_encode($response)); 

    }

}