<?php

namespace MemesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/memes/{page}", name="index")
     * @Template("Base/Base.html.twig")
     */
    public function indexAction(Request $request, $page = 1)
    {
        $SuccessMessages = $this->get('session')->getFlashBag()->get('success',array());
        $paginator = $this->get('knp_paginator');
        $Memes = $this->getDoctrine()->getRepository('MemesBundle:Memes');
        $qb = $Memes->getQueryBuilder();
        $pagination = $paginator->paginate($qb,$page,2);
        return array(
            'SuccessMessages' => $SuccessMessages ? $SuccessMessages : null,
            array(),
            'memes' => $pagination
        );
    }
}
