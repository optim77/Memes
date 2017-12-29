<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-12-29
 * Time: 13:51
 */

namespace MemesBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClassName="MemesBundle/Repository/MemesRepository")
 */
class Users
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\NotBlank
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank
     */
    private $ip;

    /**
     * @ORM\Column(type="datetime")
     */
    private $firstActivity;



}