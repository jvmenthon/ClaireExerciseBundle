<?php
/*
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

namespace SimpleIT\ClaireExerciseBundle\Controller\Frontend;

use SimpleIT\ClaireExerciseBundle\Controller\BaseController;

/**
 * Class FrontendController
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class FrontendController extends BaseController
{
    /**
     * Render front application
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException
     */
    public function indexAction()
    {
        $userId = $this->getUserId();

        if ($this->get('security.context')->isGranted('ROLE_WS_CREATOR')) {
            return $this->render(
                'SimpleITClaireExerciseBundle:Frontend:manager-layout.html.twig',
                array('currentUserId' => $userId)
            );
        } else {
            return $this->render(
                'SimpleITClaireExerciseBundle:Frontend:user-layout.html.twig',
                array('currentUserId' => $userId)
            );
        }
    }
    
    public function learnerTemplateAngularAction($file){

            return $this->render(
                    'SimpleITClaireExerciseBundle:Frontend/learner:'.$file.'.html.twig'
            );
    }

     public function teacherTemplateAngularAction($file){
        if ($this->get('security.context')->isGranted('ROLE_WS_CREATOR')) {
            return $this->render(
                    'SimpleITClaireExerciseBundle:Frontend/teacher:'.$file.'.html.twig'
            );

        }
    }

    public function jsTranslationAction(){
         return $this->render(
                'SimpleITClaireExerciseBundle:Frontend:translations.html.twig'
        );
    }
} 
