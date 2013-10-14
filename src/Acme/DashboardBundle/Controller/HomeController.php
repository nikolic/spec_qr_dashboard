<?php

namespace Acme\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeDashboardBundle:Home:index.html.twig', array());
    }

    public function createAction($name)
    {
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
