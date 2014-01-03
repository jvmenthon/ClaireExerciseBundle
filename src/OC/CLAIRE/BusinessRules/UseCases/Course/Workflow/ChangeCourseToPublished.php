<?php

namespace OC\CLAIRE\BusinessRules\UseCases\Course\Workflow;

use OC\CLAIRE\BusinessRules\Requestors\Course\Workflow\ChangeCourseStatusRequest;
use OC\CLAIRE\BusinessRules\Requestors\UseCaseRequest;
use OC\CLAIRE\BusinessRules\UseCases\Course\Workflow\DTO\ChangeCourseStatusResponseDTO;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ChangeCourseToPublished extends ChangeCourseStatus
{

    public function execute(UseCaseRequest $useCaseRequest)
    {
        /** @var ChangeCourseStatusRequest $useCaseRequest */
        $this->courseGateway->updateToPublished($useCaseRequest->getCourseId());

        return new ChangeCourseStatusResponseDTO();
    }

}
