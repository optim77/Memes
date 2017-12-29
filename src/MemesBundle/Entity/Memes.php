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
 * @ORM\Entity(repositoryClass="MemesBundle/Repository/MemesRepository")
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
     *     maxHeight=1500,
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

    /**
     * @ORM\ManyToOne(
     *      targetEntity="Users",
     *      inversedBy="actions"
     * )
     * @ORM\JoinColumn(
     *     name="user_id",
     *     referencedColumnName="id",
     *     onDelete="SET NULL"
     * )
     */
    private $author;

    /**
     * @ORM\Column(type="integer", length=4, nullable=true)
     */
    private $ratePositive = null;

    /**
     * @ORM\Column(type="integer", length=4, nullable=true)
     */
    private $rateNegative = null;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Comments",
     *     mappedBy="authors"
     * )
     */
    private $comments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Memes
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set image
     *
     * @param string $image
     *
     * @return Memes
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Memes
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
     * Set ratePositive
     *
     * @param integer $ratePositive
     *
     * @return Memes
     */
    public function setRatePositive($ratePositive)
    {
        $this->ratePositive = $ratePositive;

        return $this;
    }

    /**
     * Get ratePositive
     *
     * @return integer
     */
    public function getRatePositive()
    {
        return $this->ratePositive;
    }

    /**
     * Set rateNegative
     *
     * @param integer $rateNegative
     *
     * @return Memes
     */
    public function setRateNegative($rateNegative)
    {
        $this->rateNegative = $rateNegative;

        return $this;
    }

    /**
     * Get rateNegative
     *
     * @return integer
     */
    public function getRateNegative()
    {
        return $this->rateNegative;
    }

    /**
     * Set author
     *
     * @param \MemesBundle\Entity\Users $author
     *
     * @return Memes
     */
    public function setAuthor(\MemesBundle\Entity\Users $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \MemesBundle\Entity\Users
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add comment
     *
     * @param \MemesBundle\Entity\Comments $comment
     *
     * @return Memes
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
