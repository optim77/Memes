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
 * @ORM\Entity(repositoryClass="MemesBundle/Repository/UsersRepository")
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

    /**
     * @ORM\OneToMany(
     *     targetEntity="Memes",
     *     mappedBy="author"
     * )
     */
    private $actions;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Comments",
     *     mappedBy="mem"
     * )
     */
    private $comments;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->actions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Users
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Users
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Users
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set firstActivity
     *
     * @param \DateTime $firstActivity
     *
     * @return Users
     */
    public function setFirstActivity($firstActivity)
    {
        $this->firstActivity = $firstActivity;

        return $this;
    }

    /**
     * Get firstActivity
     *
     * @return \DateTime
     */
    public function getFirstActivity()
    {
        return $this->firstActivity;
    }

    /**
     * Add action
     *
     * @param \MemesBundle\Entity\Memes $action
     *
     * @return Users
     */
    public function addAction(\MemesBundle\Entity\Memes $action)
    {
        $this->actions[] = $action;

        return $this;
    }

    /**
     * Remove action
     *
     * @param \MemesBundle\Entity\Memes $action
     */
    public function removeAction(\MemesBundle\Entity\Memes $action)
    {
        $this->actions->removeElement($action);
    }

    /**
     * Get actions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Add comment
     *
     * @param \MemesBundle\Entity\Comments $comment
     *
     * @return Users
     */
    public function addComment(\MemesBundle\Entity\Comments $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \MemesBundle\Entity\Comments $comment
     */
    public function removeComment(\MemesBundle\Entity\Comments $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
