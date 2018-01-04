<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-12-29
 * Time: 14:36
 */

namespace MemesBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="comments")
 * @ORM\Entity(repositoryClass="MemesBundle\Repository\CommentsRepository")
 */
class Comments
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Memes",
     *     inversedBy="comments"
     * )
     * @ORM\JoinColumn(
     *     name="id_mem",
     *     referencedColumnName ="id",
     *     onDelete="SET NULL"
     * )
     */
    private $mem;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank
     * @Assert\Length(
     *     min=1,
     *     max=10
     * )
     */
    private $author;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;


    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Comments
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
     * Set content
     *
     * @param string $content
     *
     * @return Comments
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Comments
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set mem
     *
     * @param \MemesBundle\Entity\Memes $mem
     *
     * @return Comments
     */
    public function setMem(\MemesBundle\Entity\Memes $mem = null)
    {
        $this->mem = $mem;

        return $this;
    }

    /**
     * Get mem
     *
     * @return \MemesBundle\Entity\Memes
     */
    public function getMem()
    {
        return $this->mem;
    }



    /**
     * Set author
     *
     * @param string $author
     *
     * @return Comments
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
