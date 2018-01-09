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

        $Comment = new Comments();
        $em = $this->getDoctrine()->getManager();

        if($_FILES == null){

            if(isset($_POST['val'][0])){
                $comment = $_POST['val'][0];
            }
            if(isset($_POST['val'][0])){
                $author = $_POST['val'][1];
            }
            if(isset($_POST['val'][0])){
                $slug = $_POST['val'][2];
            }
            $Single = $this->getDoctrine()->getRepository('MemesBundle:Memes')->findBySlug($slug);
            $Comment->setContent($comment);
            $Comment->setDate(new \DateTime());
            $Comment->setMem($Single[0]);
            $Comment->setAuthor($author);
            $em->persist($Comment);
            $em->flush();
            $response = array('code' => 100, "success" => true);

            return new JsonResponse($response);

        }else{

            if (isset($_POST['comment'])){
                $comment = $_POST['comment'];
            }
            if (isset($_POST['author'])){
                $author = $_POST['author'];
            }
            if(isset($_POST['slug'])){
                $slug = $_POST['slug'];
            }
            $Single = $this->getDoctrine()->getRepository('MemesBundle:Memes')->findBySlug($slug);
            $Comment->setContent($comment);
            $Comment->setMediaFile($_FILES['file']);
            $Comment->setDate(new \DateTime());
            $Comment->setMem($Single[0]);
            $Comment->setAuthor($author);
            $em->persist($Comment);
            $em->flush();
            $Type = $Comment->getType();
            $Media = $Comment->getMedia();
            $response = array('code' => 100, "success" => true,'comment' => $comment, 'author' => $author,'type' => $Type , 'media' => $Media);

            return new JsonResponse($response);
        }
    }

    /**
     * @Route("/rate-positive", name="rate-positive")
     */
    public function ratePositiveAction(){
        $slug = $_POST['val'];
        $Single = $this->getDoctrine()->getRepository('MemesBundle:Memes')->findBySlug($slug);
        $Current = $Single[0]->getRatePositive();
        $Current++;
        $Single[0]->setRatePositive($Current);
        $em = $this->getDoctrine()->getManager();
        $em->persist($Single[0]);
        $em->flush();
        $response = array('code' => 100, 'success' => true);
        return new JsonResponse($response);
    }

    /**
     * @Route("/rate-negative", name="rate-negative")
     */
    public function rateNegativeAction(){
        $slug = $_POST['val'];
        $Single = $this->getDoctrine()->getRepository('MemesBundle:Memes')->findBySlug($slug);
        $Current = $Single[0]->getRateNegative();
        $Current++;
        $Single[0]->setRateNegative($Current);
        $em = $this->getDoctrine()->getManager();
        $em->persist($Single[0]);
        $em->flush();
        $response = array('code' => 100, 'success' => true);
        return new JsonResponse($response);
    }

}