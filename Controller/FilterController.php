<?php

namespace Mesd\UserBundle\Controller;

use Doctrine\ORM\Mapping\ClassMetadata;
use Mesd\UserBundle\Form\Factory\FilterFormFactory;
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
                $solventArray[] = $bunchArray;
            }

            $filterArray[] = array(
                'user' => $filter->getUser(),
                'filterCategory' => $filter->getFilterCategory(),
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
        $filterClass = $this->container->getParameter('mesd_user.filter_class');
        $userClass = $this->container->getParameter('mesd_user.user_class');
        $filterCategoryClass = $this->container->getParameter('mesd_user.filter_category_class');
        $entity = new $filterClass();
        $form = $this->createForm(
            new FilterType($filterClass, $userClass, $filterCategoryClass),
            $entity,
            array(
                'action' => $this->generateUrl('MesdUserBundle_filter_create'),
                'method' => 'POST',
            )
        );
        $form->add('create', 'submit', array(
            'label' => 'Create',
        ));

        return $this->render(
            $this->container->getParameter('mesd_user.filter.template.new'),
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function solventAction(Request $request)
    {
        $filterCategoryId = $request->query->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $filterCategoryClass = $this->container->getParameter('mesd_user.filter_category_class');
        $filterCategoryRepository = $entityManager->getRepository($filterCategoryClass);
        $filterCategory = $filterCategoryRepository->findOneById($filterCategoryId);
        $filterManager = $this->get('mesd_user.filter_manager');
        $config = $filterManager->getConfig();
        $filterCategoryName = $filterCategory->getName();
        $metadataFactory = $entityManager->getMetadataFactory();
        $entityLists = array();

        if (array_key_exists($filterCategoryName, $config)) {
            $filterCategoryConfig = $config[$filterCategoryName];
            foreach ($filterCategoryConfig['entities'] as $entity) {
                $metadata = $metadataFactory->getMetadataFor($entity['entity']['name']);
                foreach ($entity['entity']['joins'] as $join) {
                    if (!array_key_exists($join['name'], $entityLists)) {
                        $associations = explode('->', $join['trail']);
                        $associationMetadata = $metadata;
                        $length = count($associations);
                        for ($i = 0; $i < $length; $i++) {
                             $targetEntity = $associationMetadata->getAssociationMapping($associations[$i])['targetEntity'];
                             $associationMetadata = $metadataFactory->getMetadataFor($targetEntity);
                        }
                        $entities = $entityManager->getRepository($associationMetadata->getName())->findAll();
                        $entityLists[$join['name']] = $entities;
                    }
                }
            }
        } else {
            $filterCategoryConfig = null;
        }

        return $this->render(
            $this->container->getParameter('mesd_user.filter.template.solvent'),
            array(
                'filterCategoryConfig' => $filterCategoryConfig,
                'entityLists' => $entityLists,
            )
        );
    }

    public function createAction(Request $request)
    {
        $filterClass = $this->container->getParameter('mesd_user.filter_class');
        $userClass = $this->container->getParameter('mesd_user.user_class');
        $filterCategoryClass = $this->container->getParameter('mesd_user.filter_category_class');
        $entity = new $filterClass();
        $form = $this->createForm(
            new FilterType($filterClass, $userClass, $filterCategoryClass),
            $entity,
            array(
                'action' => $this->generateUrl('MesdUserBundle_filter_create'),
                'method' => 'POST',
            )
        );
        $form->add('create', 'submit', array(
            'label' => 'Create',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setSolvent(json_decode($entity->getSolvent()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('MesdUserBundle_filter_show', array('id' => $entity->getId())));
        }

        return $this->render(
            $this->container->getParameter('mesd_user.filter.template.new'),
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function showAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $filterClass = $this->container->getParameter('mesd_user.filter_class');
        $filterRepository = $entityManager->getRepository($filterClass);
        $filters = $filterRepository->findById($id);
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
                $solventArray[] = $bunchArray;
            }

            $filterArray[] = array(
                'filterCategory' => $filter->getFilterCategory(),
                'solvent' => $solventArray,
            );
        }

        return $this->render(
            $this->container->getParameter('mesd_user.filter.template.show'),
            array(
                'filters' => $filterArray,
            )
        );
    }
}