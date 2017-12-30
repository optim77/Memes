<?php

namespace MemesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template("Base/Base.html.twig")
     */
    public function indexAction()
    {
        $SuccessMessages = $this->get('session')->getFlashBag()->get('success',array());
        return array(
            'SuccessMessages' => $SuccessMessages ? $SuccessMessages : null
        );
    }
}
