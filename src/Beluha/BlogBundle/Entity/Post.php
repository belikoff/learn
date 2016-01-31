<?php

namespace Beluha\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Beluha\BlogBundle\Entity\Timestampable;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use DoctrineExtensions\Taggable\Taggable;
use Beluha\SecurityBundle\Entity\User;

/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="Beluha\BlogBundle\Repository\PostRepository")
 */
class Post extends Timestampable implements Taggable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=150)
     */
    private $title;

    /**
     *
     * @var string
     * 
     * @Gedmo\Slug(fields={"title"}, unique=false)
     * @ORM\Column(length=255)
     */
    private $slug;
    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     * @Assert\NotBlank
     */
    private $body;


    /**
     * @var Author
     *
     * @ORM\ManyToOne(targetEntity="Beluha\SecurityBundle\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank
     */
    private $author;
    
    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post", cascade={"remove"})
     */
    private $comments;
    
    /**
     * @var string
     *
     * @ORM\Column(name="keywords", type="string", length=255)
     */    
    private $keywords;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */    
    private $description;

    private $tags;
    
    /**
     *
     * @var Category
     * 
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="posts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="preview_text", type="text")
     * @Assert\NotBlank
     */
    private $preview_text;

    /**
     * @var string
     *
     * @ORM\Column(name="preview_img", type="string", length=255)
     * @Assert\NotBlank
     */
    private $preview_img;

    public function getTags()
    {
        $this->tags = $this->tags ?: new ArrayCollection();

        return $this->tags;
    }

    public function getTaggableType()
    {
        return 'tag';
    }

    public function getTaggableId()
    {
        return $this->getId();
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Post
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
     * Set body
     *
     * @param string $body
     *
     * @return Post
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }


    /**
     * Set author
     *
     * @param \Beluha\SecurityBundle\Entity\User $author
     *
     * @return Post
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Beluha\SecurityBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Post
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
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * Add comment
     *
     * @param Comment $comment
     *
     * @return Post
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
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
     * Set keywords
     *
     * @param string $keywords
     *
     * @return Post
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Post
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set category
     *
     * @param \Beluha\BlogBundle\Entity\Category $category
     *
     * @return Post
     */
    public function setCategory(\Beluha\BlogBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Beluha\BlogBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set previewText
     *
     * @param string $previewText
     *
     * @return Post
     */
    public function setPreviewText($previewText)
    {
        $this->preview_text = $previewText;

        return $this;
    }

    /**
     * Get previewText
     *
     * @return string
     */
    public function getPreviewText()
    {
        return $this->preview_text;
    }

    /**
     * Set previewImg
     *
     * @param string $previewImg
     *
     * @return Post
     */
    public function setPreviewImg($previewImg)
    {
        $this->preview_img = $previewImg;

        return $this;
    }

    /**
     * Get previewImg
     *
     * @return string
     */
    public function getPreviewImg()
    {
        return $this->preview_img;
    }
}
