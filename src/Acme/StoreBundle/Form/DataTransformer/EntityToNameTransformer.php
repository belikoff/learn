<?php
namespace Acme\StoreBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of EntityToNameTransformer
 *
 * @author Beluha
 */
class EntityToNameTransformer implements DataTransformerInterface
{
    private $om;
    private $entityClass;

    public function __construct(ObjectManager $om, $entityClass)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
    }

    public function transform($entity)
    {
        if (null === $entity) {
            return "";
        }

        return $entity->getName();
    }

    public function reverseTransform($id)
    {
        $entity = $this->om->getRepository($this->entityClass)->find($id);

        if (null === $entity) {
            throw new TransformationFailedException(sprintf('There is no entity of %s with id %s', $this->entityClass, $id
            ));
        }

        return $entity;
    }
}