<?php
/*
 * Copyright 2013 Simple IT
 *
 * This file is part of CLAIRE.
 *
 * CLAIRE is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * CLAIRE is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CLAIRE. If not, see <http://www.gnu.org/licenses/>
 */

namespace SimpleIT\ClaireAppBundle\Repository\Course;

use OC\CLAIRE\BusinessRules\Entities\Course\Course\Status;
use OC\CLAIRE\BusinessRules\Gateways\Course\Part\PartContentGateway;
use SimpleIT\ApiResourcesBundle\Course\CourseResource;
use SimpleIT\AppBundle\Repository\AppRepository;
use SimpleIT\Utils\FormatUtils;
use SimpleIT\AppBundle\Annotation\Cache;

/**
 * Class PartContentRepository
 *
 * @author Romain Kuzniak <romain.kuzniak@simple-it.fr>
 */
class PartContentRepository extends AppRepository implements PartContentGateway
{

    /**
     * @var string
     */
    protected $path = 'courses/{courseIdentifier}/parts/{partIdentifier}/content';

    /**
     * @var  string
     */
    protected $resourceClass = '';

    /**
     * Get a part content
     *
     * @param string $courseIdentifier Course id | slug
     * @param string $partIdentifier   Part id | slug
     * @param array  $parameters       Parameters
     * @param string $format           Format
     *
     * @return mixed
     * @cache (namespacePrefix="claire_app_course_course", namespaceAttribute="courseIdentifier", lifetime=0)
     */
    public function find(
        $courseIdentifier,
        $partIdentifier,
        $parameters = array(),
        $format = FormatUtils::HTML
    )
    {
        return parent::findResource(
            array('courseIdentifier' => $courseIdentifier, 'partIdentifier' => $partIdentifier),
            $parameters,
            $format
        );
    }

    /**
     * Get a part content
     *
     * @param string $courseIdentifier Course id | slug
     * @param string $partIdentifier   Part id | slug
     * @param array  $parameters       Parameters
     * @param string $format           Format
     *
     * @return mixed
     */
    public function findByStatus(
        $courseIdentifier,
        $partIdentifier,
        $parameters = array(),
        $format = FormatUtils::HTML
    )
    {
        return parent::findResource(
            array('courseIdentifier' => $courseIdentifier, 'partIdentifier' => $partIdentifier),
            $parameters,
            $format
        );
    }

//    /**
//     * Update a part content
//     *
//     * @param string $courseIdentifier Course id | slug
//     * @param string $partIdentifier   Part id | slug
//     * @param string $partContent      Part content
//     * @param array  $parameters       Parameters
//     * @param string $format           Format
//     *
//     * @return string
//     */
//    public function update(
//        $courseIdentifier,
//        $partIdentifier,
//        $partContent,
//        $parameters = array(),
//        $format = FormatUtils::HTML
//    )
//    {
//        return parent::updateResource(
//            $partContent,
//            array('courseIdentifier' => $courseIdentifier, 'partIdentifier' => $partIdentifier),
//            $parameters,
//            $format
//        );
//    }

    /**
     * @return string
     */
    public function findDraft($courseId, $partId)
    {
        return parent::findResource(
            array('courseIdentifier' => $courseId, 'partIdentifier' => $partId),
            array(CourseResource::STATUS => CourseResource::STATUS_DRAFT),
            FormatUtils::HTML
        );
    }

    /**
     * @return string
     * FIXME to remove post view change
     */
    public function findDraftForEdition($courseId, $partId)
    {
        return parent::findResource(
            array('courseIdentifier' => $courseId, 'partIdentifier' => $partId),
            array(CourseResource::STATUS => CourseResource::STATUS_DRAFT, 'edit' => true),
            FormatUtils::HTML
        );
    }

    /**
     * @return string
     */
    public function findWaitingForPublication($courseId, $partId)
    {
        return parent::findResource(
            array('courseIdentifier' => $courseId, 'partIdentifier' => $partId),
            array(CourseResource::STATUS => Status::WAITING_FOR_PUBLICATION),
            FormatUtils::HTML
        );
    }

    /**
     * @cache (namespacePrefix="claire_app_course_course", namespaceAttribute="courseIdentifier", lifetime=0)
     */
    public function findPublished($courseIdentifier, $partIdentifier)
    {
        return parent::findResource(
            array('courseIdentifier' => $courseIdentifier, 'partIdentifier' => $partIdentifier),
            array(),
            FormatUtils::HTML
        );
    }

    public function update(
        $courseId,
        $partId,
        $partContent
    )
    {
        return parent::updateResource(
            $partContent,
            array('courseIdentifier' => $courseId, 'partIdentifier' => $partId),
            array(CourseResource::STATUS => Status::DRAFT),
            FormatUtils::HTML
        );
    }
}
