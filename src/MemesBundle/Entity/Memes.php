<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-12-29
 * Time: 13:29
 */


namespace MemesBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="memes")
 * @ORM\Entity(repositoryClassName="MemesBundle/Repository/MemesRepository")
 */
class Memes
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * ORM\generatedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\NotBlank
     */
    private $image;

    /**
     * @Assert\Image(
     *     minWidth=50,
     *     maxWidth=1500,
     *     minHeight=50,
     *     maxHeight=1500
     *     maxSize="15M"
     * )
     */
    private $imageFile;


    private $imtTmp;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\NotBlank
     */
    private $slug;

    private $author;

    private $rate;

    private $comments;

}