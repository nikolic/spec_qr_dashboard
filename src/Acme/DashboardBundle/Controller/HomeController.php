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

            $quantity = $this->get('request')->request->get('quantity');

            $weight = $this->get('request')->request->get('weight');

            if(!isset($quantity) || $quantity <= 0){
                $quantity = 1;
            }

            $results = null;

            for ($i = 0; $i < $quantity; $i++){
                $results = $this->_create_qr_code($weight);
            }

            return $this->render('AcmeDashboardBundle:Home:preview.html.twig',
                                 array(
                                    "url" => $results["url"],
                                    "created" => $results["code"]->getCreated(),
                                    "filename" => $results["code"]->getFilename(),
                                    "weight" => $results["code"]->getWeight()
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

    private function _create_qr_code($weight){

        $user = $this->getUser();

        $secret = uniqid() . substr(str_shuffle(MD5(microtime())), 0, 5);

            $filename = uniqid() . ".png";

            $save_path = $this->getRequest()->server->get('DOCUMENT_ROOT');
            $save_path = $save_path . "/codes/" . $filename;

            \PHPQRCode\QRcode::png($secret, $save_path); 

            $code = new Qrcode();

            $code->setSecret($secret);
            $code->setUsed(false);
            $code->setFilename($filename);
            $code->setCreated(new \DateTime("now"));
            $code->setWeight($weight);
            $code->setUser($user->getUserId());

            $em = $this->getDoctrine()->getManager();
            $em->persist($code);
            $em->flush();

            $base_url = $this->getRequest()->getScheme() . '://' . $this->getRequest()->getHttpHost() . $this->getRequest()->getBasePath();

            return array('code' => $code, 
                         'errors' => array(),
                         'url' => $base_url . "/codes/" . $filename
                        );   

    }
}
