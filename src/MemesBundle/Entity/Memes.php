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
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="memes")
 * @ORM\Entity(repositoryClass="MemesBundle\Repository\MemesRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Memes
{

    const UPLOAD_DIR = "uploads/memes/";

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Length(
     *     min=3,
     *     max=50,
     *     groups={"mem"}
     * )
     * @Assert\NotBlank(groups={"mem"})
     */
    private $title = null;

    /**
     * @ORM\Column(type="string", length=400, nullable=true)
     * @Assert\NotBlank(groups={"phrase"})
     * @Assert\Length(
     *     min=3,
     *     max=400,
     *     groups={"phrase"}
     * )
     */
    private $phraseText = null;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $image = null;

    /**
     * @var UploadedFile
     *
     * @Assert\Image(
     *     minWidth=50,
     *     maxWidth=1500,
     *     minHeight=50,
     *     maxHeight=1500,
     *     maxSize="15M"
     * )
     */
    private $imageFile;

    /**
     * @return UploadedFile
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param UploadedFile $imageFile
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
    }


    private $imtTmp;

    /**
     * @ORM\Column(type="string", length=120, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank
     * @Assert\Length(min=2, max=30)
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
     * @ORM\Column(type="string", length=20)
     */
    private $type;


    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

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
        $this->date = new \DateTime();
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

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preSave(){
        if(null != $this->getImageFile()){
            if(null !== $this->image){
                $this->imageTemp = $this->image;
            }
            $imageName = sha1(uniqid(null,true));
            $this->image = $imageName.'.'.$this->getImageFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist
     * @ORM\PostUpdate
     */
    public function postSave(){
        if(null !== $this->getImageFile()) {
            $this->getImageFile()->move($this->getUploadRootDir(), $this->image);
            unset($this->imageFile);
        }

            if(null !== $this->imtTmp){
                unlink($this->getUploadRootDir().$this->imtTmp);
                unset($this->imtTmp);
            }
    }

    public function getUploadRootDir(){
        return __DIR__.'/../../../web/bundles/memes/uploads';
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Memes
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Memes
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

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Memes
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set phraseText
     *
     * @param string $phraseText
     *
     * @return Memes
     */
    public function setPhraseText($phraseText)
    {
        $this->phraseText = $phraseText;

        return $this;
    }

    /**
     * Get phraseText
     *
     * @return string
     */
    public function getPhraseText()
    {
        return $this->phraseText;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Memes
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
}
