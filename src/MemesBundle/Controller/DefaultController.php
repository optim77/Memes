<?php

namespace MemesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    const ITEM_PER_PAGE = 10;

    /**
     * @Route("/main/{page}", name="index")
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
        return array(
            'view' => $qb[0]
        );

    }

    /**
     * @Route("/memes/{page}", name="memes")
     * @Template("Memes/Memes.html.twig")
     */
    public function getMemesAction(Request $request,$page = 1){
        $Memes = $this->getDoctrine()->getRepository('MemesBundle:Memes');
        $qb = $Memes->getMemes();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb,$page,DefaultController::ITEM_PER_PAGE);
        return array(
            'memes' => $pagination
        );
    }

    /**
     * @Route("/phrases/{page}", name="phrases")
     * @Template("Phrases/Phrase.html.twig")
     */
    public function getPhrasesAction($page = 1){
        $Phrases = $this->getDoctrine()->getRepository('MemesBundle:Memes');
        $qb = $Phrases->getPhrases();
        $paginator = $this->get('knp_paginator');
        $pagination  = $paginator->paginate($qb,$page,DefaultController::ITEM_PER_PAGE);
        return array(
            'memes' => $pagination
        );
    }

    /**
     * @Route("/top/{page}", name="top")
     * @Template("Top/Top.html.twig")
     */
    public function getTopAction($page = 1){
        $Memes = $this->getDoctrine()->getRepository('MemesBundle:Memes');
        $qb = $Memes->getTop();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb,$page,DefaultController::ITEM_PER_PAGE);
        return array(
            'memes' => $pagination
        );
    }
}
