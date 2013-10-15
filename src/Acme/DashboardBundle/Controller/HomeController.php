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
        // $code = new Qrcode();

        // $code->setSecret("xx3x111");
        // $code->setUsed(false);
        // $code->setFilename("tes2t.png");
        // $code->setCreated(new \DateTime("now"));

        // $em = $this->getDoctrine()->getManager();
        // $em->persist($code);
        // $em->flush();


        return $this->render('AcmeDashboardBundle:Home:create.html.twig', array('name' => $name));
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
}
