<?php

namespace Beluha\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AuthorQuote
 *
 * @ORM\Table(name="author_quote")
 * @ORM\Entity(repositoryClass="Beluha\StoreBundle\Repository\AuthorQuoteRepository")
 */
class AuthorQuote
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Quote", mappedBy="author")
     */
    protected $quotes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->quotes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return AuthorQuote
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
     * Add quote
     *
     * @param \Beluha\StoreBundle\Entity\Quote $quote
     *
     * @return AuthorQuote
     */
    public function addQuote(\Beluha\StoreBundle\Entity\Quote $quote)
    {
        $this->quotes[] = $quote;

        return $this;
    }

    /**
     * Remove quote
     *
     * @param \Beluha\StoreBundle\Entity\Quote $quote
     */
    public function removeQuote(\Beluha\StoreBundle\Entity\Quote $quote)
    {
        $this->quotes->removeElement($quote);
    }

    /**
     * Get quotes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuotes()
    {
        return $this->quotes;
    }
}
