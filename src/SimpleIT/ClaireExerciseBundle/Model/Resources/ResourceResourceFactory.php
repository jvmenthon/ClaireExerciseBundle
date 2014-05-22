<?php
namespace SimpleIT\ClaireExerciseBundle\Model\Resources;

use JMS\Serializer\Handler\HandlerRegistry;
use SimpleIT\ClaireExerciseBundle\Entity\DomainKnowledge\Knowledge;
use SimpleIT\ClaireExerciseBundle\Entity\ExerciseResource\ExerciseResource;
use SimpleIT\ClaireExerciseBundle\Model\Resources\ResourceResource;
use SimpleIT\Utils\Collection\PaginatorInterface;

/**
 * Class ResourceResourceFactory
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
abstract class ResourceResourceFactory extends SharedResourceFactory
{

    /**
     * Create an ResourceResource collection
     *
     * @param PaginatorInterface $resources
     *
     * @return array
     */
    public static function createCollection(PaginatorInterface $resources)
    {
        $resourceResources = array();
        foreach ($resources as $resource) {
            $resourceResources[] = self::create($resource);
        }

        return $resourceResources;
    }

    /**
     * Create a ResourceResource
     *
     * @param ExerciseResource $resource
     *
     * @return ResourceResource
     */
    public static function create(ExerciseResource $resource)
    {
        $resourceResource = new ResourceResource();
        parent::fill(
            $resourceResource,
            $resource
        );

        // required resources
        $requirements = array();
        foreach ($resource->getRequiredExerciseResources() as $req) {
            /** @var ExerciseResource $req */
            $requirements[] = $req->getId();
        }
        $resourceResource->setRequiredExerciseResources($requirements);

        // required resources
        $requirements = array();
        foreach ($resource->getRequiredKnowledges() as $req) {
            /** @var Knowledge $req */
            $requirements[] = $req->getId();
        }
        $resourceResource->setRequiredKnowledges($requirements);

        return $resourceResource;
    }
}