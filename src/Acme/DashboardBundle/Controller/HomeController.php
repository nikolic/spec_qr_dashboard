<?php

namespace Acme\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\DashboardBundle\Entity\Qrcode;

class HomeController extends Controller
{
    public function indexAction()
    {
        $securityContext = $this->container->get('security.context');
        if( $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') ){
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->render('AcmeDashboardBundle:Home:index.html.twig', array());
        }
        else{
            return $this->redirect($this->generateUrl('fos_user_security_login', array()));
        }
        
    }

    public function createAction($name)
    {

        if($this->get('request')->getMethod() == "GET"){
            return $this->render('AcmeDashboardBundle:Home:create.html.twig', array('name' => $name));
        }
        elseif($this->get('request')->getMethod() == "POST"){

            $results = $this->_create_qr_code();

            return $this->render('AcmeDashboardBundle:Home:preview.html.twig',
                                 array(
                                    'url' => $results["url"] 
                                    ));

        }
        else{

        }

    }

    public function statisticsAction($name)
    {
        return $this->render('AcmeDashboardBundle:Home:statistics.html.twig', array('name' => $name));
    }

    public function reportsAction($name)
    {
        return $this->render('AcmeDashboardBundle:Home:reports.html.twig', array('name' => $name));
    }

    public function settingsAction($name)
    {
        return $this->render('AcmeDashboardBundle:Home:settings.html.twig', array('name' => $name));
    }

    private function _create_qr_code(){

        $secret = uniqid() . substr(str_shuffle(MD5(microtime())), 0, 5);
 
        // $repository = $this->getDoctrine()->getRepository('AcmeDashboardBundle:Qrcode');
        // $exist = $repository->findOneBy(array('secret' => $secret));

      //  if(!$exist){

            $filename = uniqid() . ".png";

            $save_path = $this->getRequest()->server->get('DOCUMENT_ROOT');
            $save_path = $save_path . "/codes/" . $filename;

            \PHPQRCode\QRcode::png($secret, $save_path); 

            $code = new Qrcode();

            $code->setSecret($secret);
            $code->setUsed(false);
            $code->setFilename($filename);
            $code->setCreated(new \DateTime("now"));

            $em = $this->getDoctrine()->getManager();
            $em->persist($code);
            $em->flush();

        // }
        // else{


        // } 

        return array('code' => $code, 
                     'errors' => array(),
                     'url' => "http://localhost:8000/codes/" . $filename
                    );   

    }
}
