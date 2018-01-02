<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2018-01-02
 * Time: 13:38
 */

namespace MemesBundle\Forms;

use MemesBundle\Entity\Memes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddNewPhraseType extends AbstractType
{

    public function getBlockPrefix()
    {
        return null;
    }

    public function getName(){
        return 'addNewPhraseType';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phraseText',TextType::class,array(
                'label' => 'Phrase (max 300 chars)'
            ))
            ->add('author',TextType::class,array(
                'label' => 'Your name'
            ))
            ->add('submit',SubmitType::class,array(
                'label' => 'Send'
            ));
    }

    public function setDefaultOptions(OptionsResolver $resolver){

        $resolver->setDefaults(array(
            'data_class' => Memes::class,
            'validation_groups' => array('phrase'),
        ));

    }

}