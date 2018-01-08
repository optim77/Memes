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
use MemesBundle\Forms\AddNewPhraseType;
use MemesBundle\Tools\ConstantValues;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class AddController extends Controller
{

    const MEM_TYPE = 'mem';
    const PHRASE_TYPE = 'phrase';
    const VIDEOS_TYPE = 'video';


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
            //$Mem->setType(AddController::MEM_TYPE);
            $Mem->setSlug($slug);
            $em->persist($Mem);
            $em->flush();
            $message = $this->get('session')->getFlashBag()->add('success','You add new mem');
            return $this->redirectToRoute('index');
        }

        return array(
            'type' => AddController::MEM_TYPE,
            'formMem' => $form->createView()
        );

    }

    /**
     * @Route("/add-phrase", name="add-phrase")
     * @Template("Add/AddNew.html.twig")
     */
    public function addNewPhraseAction(Request $request){

        $Phrase = new Memes();
        $Messages = $this->get('session')->getFlashBag()->get('danger',array());
        $form = $this->createForm(AddNewPhraseType::class, $Phrase);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $ContentText = $_POST['phraseText'];
            if(strlen($ContentText) > 300){
                $message = $this->get('session')->getFlashBag()->add('danger','The phrase is too length');
                return $this->redirectToRoute('add-phrase');
            }
            //$backgroundColor =  array_rand(AddController::COLORS,1);
            $Colors = new ConstantValues();
            $backgroundColor = $Colors->getOne();
            $text = '<div class="card text-center soloCard mb-5 col-md-10 p-5" style="background-color: '.$backgroundColor.'" ><div class="card-block"><h4 class="card-title">'.$ContentText.'</h4></div></div>';
            $slug = substr($_POST['phraseText'],0,60).uniqid(null,true);
            $slug = self::slugify($slug);
            $Phrase->setSlug($slug);
            $Phrase->setPhraseText($text);
            $Phrase->setType(AddController::PHRASE_TYPE);
            $em->persist($Phrase);
            $em->flush();
            $message = $this->get('session')->getFlashBag()->add('success','You add new pharse');
            return $this->redirectToRoute('index');
        }


        return array(
            'Messages' => $Messages ? $Messages : null,
            'type' => AddController::PHRASE_TYPE,
            'formPhrase' => $form->createView()
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