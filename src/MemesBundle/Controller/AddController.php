<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-12-29
 * Time: 20:13
 */

namespace MemesBundle\Controller;

use MemesBundle\Entity\Memes;
use MemesBundle\Entity\Users;
use MemesBundle\Forms\AddNew;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AddController extends Controller
{

    /**
     * @Route("/add", name="addNew")
     * @Template("Add/AddNew.html.twig")
     */
    public function addNewAction(Request $request){

        $Mem = new Memes();
        $User = new Users();
        $form = $this->createForm(AddNew::class,$Mem);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $slug = $_POST['title'].uniqid(null,true);
            $slug = self::slugify($slug);
            $Mem->setSlug($slug);
            $em->persist($Mem);
            $em->flush();
            $message = $this->get('session')->getFlashBag()->add('success','You add new mem');
            return $this->redirectToRoute('index');
        }

        return array(
            'form' => $form->createView()
        );

    }

    static public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

}