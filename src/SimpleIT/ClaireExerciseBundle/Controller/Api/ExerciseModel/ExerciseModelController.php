<?php
namespace SimpleIT\ClaireExerciseBundle\Controller\Api\ExerciseModel;

use Doctrine\DBAL\DBALException;
use SimpleIT\ClaireExerciseBundle\Exception\Api\ApiBadRequestException;
use SimpleIT\ClaireExerciseBundle\Exception\Api\ApiConflictException;
use SimpleIT\ClaireExerciseBundle\Exception\Api\ApiNotFoundException;
use SimpleIT\ClaireExerciseBundle\Model\Api\ApiCreatedResponse;
use SimpleIT\ClaireExerciseBundle\Model\Api\ApiDeletedResponse;
use SimpleIT\ClaireExerciseBundle\Model\Api\ApiEditedResponse;
use SimpleIT\ClaireExerciseBundle\Model\Api\ApiGotResponse;
use SimpleIT\ClaireExerciseBundle\Model\Api\ApiResponse;
use SimpleIT\ClaireExerciseBundle\Controller\Api\ApiController;
use SimpleIT\ClaireExerciseBundle\Entity\ExerciseModel\ExerciseModel;
use SimpleIT\ClaireExerciseBundle\Exception\EntityDeletionException;
use SimpleIT\ClaireExerciseBundle\Exception\FilterException;
use SimpleIT\ClaireExerciseBundle\Exception\InvalidTypeException;
use SimpleIT\ClaireExerciseBundle\Exception\NoAuthorException;
use SimpleIT\ClaireExerciseBundle\Exception\NonExistingObjectException;
use SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModelResource;
use SimpleIT\ClaireExerciseBundle\Model\Resources\ExerciseModelResourceFactory;
use SimpleIT\ClaireExerciseBundle\Model\Collection\CollectionInformation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * API Exercise Model controller
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class ExerciseModelController extends ApiController
{
    /**
     * Get a specific exerciseModel resource
     *
     * @param int $exerciseModelId Exercise Model id
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \SimpleIT\ClaireExerciseBundle\Exception\Api\ApiNotFoundException
     * @return ApiGotResponse
     */
    public function viewAction($exerciseModelId)
    {
        try {
            /** @var ExerciseModel $exerciseModel */
            $exerciseModelResource = $this->get(
                'simple_it.exercise.exercise_model'
            )->getContentFullResource
                (
                    $exerciseModelId,
                    $this->getUserId()
                );

            return new ApiGotResponse($exerciseModelResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        }
    }

    /**
     * Get the list of exercise models. In the collection information filters (url filters),
     * type is used for the type of the exercise and all other values are used to search in
     * metadata.
     *
     * @param CollectionInformation $collectionInformation
     *
     * @throws ApiBadRequestException
     * @return ApiGotResponse
     */
    public function listAction(CollectionInformation $collectionInformation)
    {
        try {
            $exerciseModels = $this->get('simple_it.exercise.exercise_model')->getAll(
                $collectionInformation,
                $userId = $this->getUserId()

            );

            $exerciseModelResources = $this->get(
                'simple_it.exercise.exercise_model'
            )->getAllContentFullResourcesFromEntityList(
                    $exerciseModels
                );

            return new ApiGotResponse($exerciseModelResources, array(
                'list',
                'Default'
            ));
        } catch (FilterException $fe) {
            throw new ApiBadRequestException($fe->getMessage());
        }
    }

    /**
     * Create a new model (without metadata)
     *
     * @param ExerciseModelResource $modelResource
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiResponse
     */
    public function createAction(
        ExerciseModelResource $modelResource
    )
    {
        try {
            $userId = $this->getUserId();

            $this->validateResource($modelResource, array('create', 'Default'));

            $modelResource->setAuthor($userId);
            $modelResource->setOwner($userId);

            /** @var ExerciseModel $model */
            $model = $this->get('simple_it.exercise.exercise_model')->createAndAdd
                (
                    $modelResource
                );

            $modelResource = ExerciseModelResourceFactory::create($model);

            return new ApiCreatedResponse($modelResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        } catch (NoAuthorException $nae) {
            throw new ApiBadRequestException($nae->getMessage());
        }
    }

    /**
     * Edit a model
     *
     * @param ExerciseModelResource $modelResource
     * @param int                   $exerciseModelId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @throws ApiConflictException
     * @return ApiEditedResponse
     */
    public function editAction(ExerciseModelResource $modelResource, $exerciseModelId)
    {
        try {
            $this->validateResource($modelResource, array('edit', 'Default'));

            $modelResource->setId($exerciseModelId);

            $model = $this->get('simple_it.exercise.exercise_model')->edit
                (
                    $modelResource,
                    $this->getUserId()
                );
            $modelResource = ExerciseModelResourceFactory::create($model);

            return new ApiEditedResponse($modelResource);

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        } catch (DBALException $eoe) {
            throw new ApiConflictException($eoe->getMessage());
        } catch (NoAuthorException $nae) {
            throw new ApiBadRequestException($nae->getMessage());
        } catch (InvalidTypeException $ite) {
            throw new ApiBadRequestException($ite->getMessage());
        }
    }

    /**
     * Delete a model
     *
     * @param int $exerciseModelId
     *
     * @throws \SimpleIT\ClaireExerciseBundle\Exception\Api\ApiNotFoundException
     * @throws \SimpleIT\ClaireExerciseBundle\Exception\Api\ApiBadRequestException
     * @return ApiDeletedResponse
     */
    public function deleteAction($exerciseModelId)
    {
        try {
            $this->get('simple_it.exercise.exercise_model')->remove(
                $exerciseModelId,
                $this->getUserId()
            );

            return new ApiDeletedResponse();

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        } catch (EntityDeletionException $ede) {
            throw new ApiBadRequestException($ede->getMessage());
        }
    }

    /**
     * Subscribe to a model
     *
     * @param int $exerciseModelId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiResponse
     */
    public function subscribeAction($exerciseModelId)
    {
        try {
            $model = $this->get('simple_it.exercise.exercise_model')->subscribe(
                $this->getUserId(),
                $exerciseModelId
            );

            $modelResource = ExerciseModelResourceFactory::create($model);

            return new ApiCreatedResponse($modelResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        }
    }

    /**
     * Duplicate a model
     *
     * @param int $exerciseModelId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiResponse
     */
    public function duplicateAction($exerciseModelId)
    {
        try {
            /** @var ExerciseModel $model */
            $model = $this->get('simple_it.exercise.exercise_model')->duplicate(
                $exerciseModelId,
                $this->getUserId()
            );

            $modelResource = ExerciseModelResourceFactory::create($model);

            return new ApiCreatedResponse($modelResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        }
    }

    /**
     * Import a model
     *
     * @param int $exerciseModelId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiResponse
     */
    public function importAction($exerciseModelId)
    {
        try {
            /** @var ExerciseModel $model */
            $model = $this->get('simple_it.exercise.exercise_model')->import(
                $this->getUserId(),
                $exerciseModelId
            );

            $modelResource = ExerciseModelResourceFactory::create($model);

            return new ApiCreatedResponse($modelResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        }
    }
}