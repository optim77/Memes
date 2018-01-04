<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2018-01-02
 * Time: 23:08
 */

namespace MemesBundle\Controller;

use MemesBundle\Entity\Comments;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxController extends Controller
{

    /**
     * @Route("/add-comment", name="add-comment")
     */
    public function addCommentAction(){
        $comment = $_POST['val'][0];
        $author = $_POST['val'][1];
        $slug = $_POST['val'][2];
        $Single = $this->getDoctrine()->getRepository('MemesBundle:Memes')->findBySlug($slug);
        $Comment = new Comments();
        $em = $this->getDoctrine()->getManager();
        $Comment->setContent($comment);
        $Comment->setDate(new \DateTime());
        $Comment->setMem($Single[0]);
        $Comment->setAuthor($author);
        $em->persist($Comment);
        $em->flush();
        $response = array('code' => 100, "success" => true);

        return new JsonResponse($response);
    }

}