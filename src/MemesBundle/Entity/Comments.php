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
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="comments")
 * @ORM\Entity(repositoryClass="MemesBundle\Repository\CommentsRepository")
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $media = null;

    /**
     * @var UploadedFile
     *
     * @Assert\File(
     *     mimeTypes={"image/jpeg","image/gif","image/png","video/mp4","video/webm","video/ogg"},
     *     maxSize="20M"
     * )
     */
    private $mediaFile;

    private $mediaTmp;



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
     * @ORM\Column(type="string", length=20)
     */
    private $type;

    /**
     * Comments constructor.
     */
    public function __construct()
    {
        $this->type = 'phrase';
    }


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
     * @return UploadedFile
     */
    public function getMediaFile()
    {
        return $this->mediaFile;
    }

    /**
     * @param UploadedFile $mediaFile
     */
    public function setMediaFile($mediaFile)
    {
        $this->mediaFile = $mediaFile;
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

    /**
     * Set media
     *
     * @param string $media
     *
     * @return Comments
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return string
     */
    public function getMedia()
    {
        return $this->media;
    }


    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preSave(){
        if(null != $this->getMediaFile()){
            if(null !== $this->media){
                $this->mediaTmp = $this->media;
            }
            $imageName = sha1(uniqid(null,true));
            $file = $this->getMediaFile();
            $extension = explode('/',$file['type']);
            $this->media = $imageName.'.'.$extension[1];
            if($extension == 'mp4' || $extension == 'ogg' || $extension == 'webm'){
                $this->setType('video');
            }
            if($extension == 'jpeg' || $extension == 'gif' || $extension == 'png'){
                $this->setType('mem');
            }

        }
    }

    /**
     * @ORM\PostPersist
     * @ORM\PostUpdate
     */
    public function postSave(){
        if(null !== $this->getMediaFile()) {
            $file = $this->getMediaFile();
            $tmp = $file['tmp_name'];
            move_uploaded_file($tmp,__DIR__.'/../../../web/bundles/memes/uploads/'.$this->media);
            //$tmp->move($this->getUploadRootDir(), $this->media);
            unset($this->imageFile);
        }

        if(null !== $this->mediaTmp){
            unlink($this->getUploadRootDir().$this->mediaTmp);
            unset($this->mediaTmp);
        }
    }

    public function getUploadRootDir(){
        return __DIR__.'/../../../web/bundles/memes/uploads';
    }


    /**
     * Set type
     *
     * @param string $type
     *
     * @return Comments
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
}
