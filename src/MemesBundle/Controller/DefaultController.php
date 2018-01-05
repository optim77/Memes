<?php

namespace MemesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    const ITEM_PER_PAGE = 5;

    /**
     * @Route("/{page}", name="index")
     * @Template("Base/Base.html.twig")
     */
    public function indexAction(Request $request, $page = 1)
    {
        $SuccessMessages = $this->get('session')->getFlashBag()->get('success',array());
        $paginator = $this->get('knp_paginator');
        $Memes = $this->getDoctrine()->getRepository('MemesBundle:Memes');
        $qb = $Memes->getQueryBuilder();
        $pagination = $paginator->paginate($qb,$page,DefaultController::ITEM_PER_PAGE);
        return array(
            'SuccessMessages' => $SuccessMessages ? $SuccessMessages : null,
            'memes' => $pagination
        );
    }

    /**
     * @Route("/single/{slug}", name="single")
     * @Template("Single/Single.html.twig")
     */
    public function singleAction($slug){

        $Memes = $this->getDoctrine()->getRepository('MemesBundle:Memes');
        $qb = $Memes->getSingle($slug);
        dump($qb);
        return array(
            'view' => $qb[0]
        );

    }

    /**
     * @Route("/memes/{page}", name="memes")
     *
     */
    public function getMemesAction($page){
        $Memes = $this->getDoctrine()->getRepository('MemesBundle:Memes');
        $qb = $Memes->getMemes();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb,$page,DefaultController::ITEM_PER_PAGE);
        return array(
            'memes' => $pagination
        );
    }
}
