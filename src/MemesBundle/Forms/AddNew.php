<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-12-29
 * Time: 20:16
 */

namespace MemesBundle\Forms;

use MemesBundle\Entity\Memes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class AddNew extends AbstractType
{
    public function getName(){

        return 'addForm';

    }

    public function getBlockPrefix()
    {
        return null;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,array(
                'label' => 'Title'
            ))
            ->add('imageFile',FileType::class,array(
                'label' => 'File'
            ))
            ->add('author',TextType::class,array(
                'label' => 'Your name'
            ))
            ->add('submit',SubmitType::class,array(
                'label' => 'Send'
            ));
    }

    public function setDefaultOptions(OptionsResolver $resolver){
        $resolver = array(
            'data_class' => Memes::class
        );
    }
}