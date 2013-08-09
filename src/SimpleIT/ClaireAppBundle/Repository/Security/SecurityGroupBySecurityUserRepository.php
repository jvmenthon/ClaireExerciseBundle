<?php

namespace SimpleIT\ClaireAppBundle\Repository\Security;

use SimpleIT\AppBundle\Repository\AppRepository;
use SimpleIT\Utils\Collection\CollectionInformation;
use SimpleIT\ApiResourcesBundle\Security\GroupResource;
use SimpleIT\Utils\Collection\PaginatedCollection;

/**
 * Class SecurityGroupBySecurityUserRepository
 *
 * @author Kévin Letord <kevin.letord@simple-it.fr>
 */
class SecurityGroupBySecurityUserRepository extends AppRepository
{
    /**
     * @var string
     */
    protected $path = '/security-users/{userId}/security-groups/{groupId}';

    /**
     * @var  string
     */
    protected $resourceClass = 'SimpleIT\ApiResourcesBundle\Security\GroupResource';

    /**
     * Find a list of security group
     *
     * @param int                   $userId                User id
     * @param CollectionInformation $collectionInformation Collection Information
     *
     * @return PaginatedCollection
     */
    public function findAll($userId, CollectionInformation $collectionInformation = null)
    {
        return parent::findAllResources(
            array(
                'userId' => $userId,
                $collectionInformation
            )
        );
    }

    /**
     * Associate a group to an user
     *
     * @param int           $userId
     * @param GroupResource $group
     *
     * @return GroupResource
     */
    public function insert($userId, GroupResource $group)
    {
        return parent::insertResource(
            $group,
            array(
                'userId' => $userId,
            )
        );
    }

    /**
     * Disassociate an user from a group
     *
     * @param int $userId  User id
     * @param int $groupId Group id
     */
    public function delete($userId, $groupId)
    {
        parent::deleteResource(
            array(
                'userId'  => $userId,
                'groupId' => $groupId,
            )
        );
    }

    /**
     * Disassociate all group from an user
     *
     * @param int $userId  User id
     */
    public function deleteAll($userId)
    {
        parent::deleteResource(
            array(
                'userId' => $userId,
            )
        );
    }
}