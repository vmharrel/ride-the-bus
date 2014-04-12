<?php

namespace RidePal\SingleRideTicketsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SingleRideTicketsController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RidePalSingleRideTicketsBundle:Default:index.html.twig', array('name' => $name));
    }
}
