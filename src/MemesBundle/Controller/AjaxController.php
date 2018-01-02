<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2018-01-02
 * Time: 23:08
 */

namespace MemesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AjaxController extends Controller
{

    /**
     * @Route("/add-comment", name="add-comment")
     */
    public function addCommentAction(){
        $comment = $_POST['comment'];
    }

}