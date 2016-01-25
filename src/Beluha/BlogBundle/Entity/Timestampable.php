<?php

namespace Beluha\BlogBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Timestampable abstract class to define created and updated behavior
 *
 * @author Maria-Alexey
 * 
 * @ORM\MappedSuperclass
 */
abstract class Timestampable
{
    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private $updateAt;    
    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Timestampable
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /*Больше не нужен, так как мы используем 
     * stof_doctrine_extensions:
    orm:
        default:
            timestampable: true
            sluggable: true
    public function __construct() 
    {
        $this->createdAt = new \DateTime();

    }*/
    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Timestampable
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }    
}
