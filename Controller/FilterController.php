<?php

namespace Mesd\UserBundle\Controller;

use Doctrine\ORM\Mapping\ClassMetadata;
use Mesd\UserBundle\Form\Type\FilterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FilterController extends Controller
{
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $filterClass = $this->container->getParameter('mesd_user.filter_class');
        $filterRepository = $entityManager->getRepository($filterClass);
        $filters = $filterRepository->findAll();
        $filterManager = $this->get('mesd_user.filter_manager');
        $metadataFactory = $entityManager->getMetadataFactory();

        $filterArray = array();
        foreach ($filters as $filter) {
            $solvents = $filter->getSolventWrappers();
            $solventArray = array();
            foreach ($solvents as $solvent) {
                $bunchArray = array();
                foreach ($solvent->getBunch() as $bunch) {
                    $entityArray = array();
                    foreach ($bunch->getEntity() as $entity) {
                        $metadata = $metadataFactory->getMetadataFor($entity->getName());
                        $joinArray = array();
                        foreach ($entity->getJoin() as $join) {
                            $associationMetadata = $metadata;
                            $associations = $join->getAssociation();
                            $length = count($associations);
                            for ($i = 0; $i < $length; $i++) {
                                 $targetEntity = $associationMetadata->getAssociationMapping($associations[$i])['targetEntity'];
                                 $associationMetadata = $metadataFactory->getMetadataFor($targetEntity);
                            }
                            $entity = $entityManager->getRepository($associationMetadata->getName())->findOneById($join->getValue());
                            $joinArray[] = array(
                                'name' => $join->getName(),
                                'item' => (string) $entity,
                            );
                        }
                        $entityArray[] = $joinArray;
                    }
                    $bunchArray[] = $entityArray;
                }
                $solventArray = $bunchArray;
            }

            $filterArray[] = array(
                'user' => $filter->getUser(),
                'role' => $filter->getRole(),
                'solvent' => $solventArray,
            );
        }

        return $this->render(
            $this->container->getParameter('mesd_user.filter.template.index'),
            array(
                'filters' => $filterArray,
            )
        );
    }

    public function newAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $filterClass = $this->container->getParameter('mesd_user.filter_class');
        $userClass = $this->container->getParameter('mesd_user.user_class');
        $roleClass = $this->container->getParameter('mesd_user.role_class');
        $form = $this->createForm(
            new FilterType($filterClass, $userClass, $roleClass)
        );

        return $this->render(
            $this->container->getParameter('mesd_user.filter.template.new'),
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function solventAction(Request $request)
    {
        $roleId = $request->query->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $roleClass = $this->container->getParameter('mesd_user.role_class');
        $roleRepository = $entityManager->getRepository($roleClass);
        $role = $roleRepository->findOneById($roleId);
        $filterManager = $this->get('mesd_user.filter_manager');
        $config = $filterManager->getConfig();
        $roleName = $role->getName();
        if (array_key_exists($roleName, $config)) {
            $roleConfig = $config[$roleName];
        } else {
            $roleConfig = null;
        }
        $response = new JsonResponse();
        $response->setData(
            array(
                'id' => $roleId,
                'name' => $roleName,
                'description' => $role->getDescription(),
                'config' => $roleConfig,
            )
        );

        return $response;
    }
}