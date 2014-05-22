<?php
namespace SimpleIT\ClaireExerciseBundle\Controller\Api\DomainKnowledge;

use SimpleIT\ApiBundle\Controller\ApiController;
use SimpleIT\ApiBundle\Exception\ApiBadRequestException;
use SimpleIT\ApiBundle\Exception\ApiConflictException;
use SimpleIT\ApiBundle\Exception\ApiNotFoundException;
use SimpleIT\ApiBundle\Model\ApiCreatedResponse;
use SimpleIT\ApiBundle\Model\ApiDeletedResponse;
use SimpleIT\ApiBundle\Model\ApiEditedResponse;
use SimpleIT\ApiBundle\Model\ApiGotResponse;
use SimpleIT\ApiBundle\Model\ApiPaginatedResponse;
use SimpleIT\ApiBundle\Model\ApiResponse;
use SimpleIT\ApiResourcesBundle\Exception\InvalidKnowledgeException;
use SimpleIT\ClaireExerciseBundle\Model\Resources\KnowledgeResource;
use SimpleIT\CoreBundle\Exception\ExistingObjectException;
use SimpleIT\CoreBundle\Exception\NonExistingObjectException;
use SimpleIT\ClaireExerciseBundle\Exception\NoAuthorException;
use SimpleIT\ClaireExerciseBundle\Model\Resources\KnowledgeResourceFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * API Knowledge controller
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class KnowledgeController extends ApiController
{
    /**
     * View action. View a knowledge.
     *
     * @param int $knowledgeId
     *
     * @throws ApiNotFoundException
     * @return ApiGotResponse
     */
    public function viewAction($knowledgeId)
    {
        try {
            // Call to the knowledge service to get the knowledge
            $knowledge = $this->get('simple_it.exercise.knowledge')->get($knowledgeId);

            $knowledgeResource = KnowledgeResourceFactory::create($knowledge, false);

            return new ApiGotResponse($knowledgeResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(KnowledgeResource::RESOURCE_NAME);
        }
    }

    /**
     * Get all items
     *
     * @throws ApiNotFoundException
     * @return ApiPaginatedResponse
     */
    public function listAction()
    {
        try {
            $knowledges = $this->get('simple_it.exercise.knowledge')->getAll();

            $knowledgeResources = KnowledgeResourceFactory::createCollection($knowledges);

            return new ApiPaginatedResponse($knowledgeResources, $knowledges, array(
                'knowledge_list',
                'Default'
            ));
        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(KnowledgeResource::RESOURCE_NAME);
        }
    }

    /**
     * Create a new knowledge (without metadata)
     *
     * @param KnowledgeResource $knowledgeResource
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiResponse
     */
    public function createAction(KnowledgeResource $knowledgeResource)
    {
        try {
            $userId = null;
            if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $userId = $this->get('security.context')->getToken()->getUser()->getId();
            }

            $this->validateResource($knowledgeResource, array('create'));

            $knowledge = $this->get('simple_it.exercise.knowledge')->createAndAdd
                (
                    $knowledgeResource,
                    $userId
                );

            $knowledgeResource = KnowledgeResourceFactory::create($knowledge);

            return new ApiCreatedResponse($knowledgeResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(KnowledgeResource::RESOURCE_NAME);
        } catch (NoAuthorException $nae) {
            throw new ApiBadRequestException($nae->getMessage());
        } catch (InvalidKnowledgeException $ike) {
            throw new ApiBadRequestException($ike->getMessage());
        }
    }

    /**
     * Edit a knowledge
     *
     * @param KnowledgeResource $knowledgeResource   knowledge resource
     * @param int               $knowledgeId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @throws ApiConflictException
     * @return ApiEditedResponse
     */
    public function editAction(KnowledgeResource $knowledgeResource, $knowledgeId)
    {
        try {
            $this->validateResource($knowledgeResource, array('edit', 'Default'));

            $knowledge = $this->get('simple_it.exercise.knowledge')->edit
                (
                    $knowledgeResource,
                    $knowledgeId
                );
            $knowledgeResource = KnowledgeResourceFactory::create($knowledge);

            return new ApiEditedResponse($knowledgeResource);

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(KnowledgeResource::RESOURCE_NAME);
        } catch (ExistingObjectException $eoe) {
            throw new ApiConflictException($eoe->getMessage());
        } catch (NoAuthorException $nae) {
            throw new ApiBadRequestException($nae->getMessage());
        }
    }

    /**
     * Delete a knowledge
     *
     * @param int $knowledgeId
     *
     * @return \SimpleIT\ApiBundle\Model\ApiDeletedResponse
     * @throws ApiNotFoundException
     * @return ApiDeletedResponse
     */
    public function deleteAction($knowledgeId)
    {
        try {
            $this->get('simple_it.exercise.knowledge')->remove($knowledgeId);

            return new ApiDeletedResponse();

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(KnowledgeResource::RESOURCE_NAME);
        }
    }
}