<?php

namespace Beluha\BlogBundle\Entity;

use \FPN\TagBundle\Entity\Tag as BaseTag;
use Doctrine\ORM\Mapping as ORM;

/**
 * Beluha\BlogBundle\Entity\Tag
 * 
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="\DoctrineExtensions\Taggable\Entity\TagRepository")
 */
class Tag extends BaseTag
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Tagging", mappedBy="tag", fetch="EAGER")
     **/
    protected $tagging;

    /**
     * Add tagging
     *
     * @param \Beluha\BlogBundle\Entity\Tagging $tagging
     *
     * @return Tag
     */
    public function addTagging(\Beluha\BlogBundle\Entity\Tagging $tagging)
    {
        $this->tagging[] = $tagging;

        return $this;
    }

    /**
     * Remove tagging
     *
     * @param \Beluha\BlogBundle\Entity\Tagging $tagging
     */
    public function removeTagging(\Beluha\BlogBundle\Entity\Tagging $tagging)
    {
        $this->tagging->removeElement($tagging);
    }

    /**
     * Get tagging
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTagging()
    {
        return $this->tagging;
    }
}
