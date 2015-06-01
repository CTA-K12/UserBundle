<?php

namespace Mesd\UserBundle\Controller;

use Doctrine\ORM\Mapping\ClassMetadata;
use Mesd\UserBundle\Form\Factory\FilterFormFactory;
use Mesd\UserBundle\Form\Type\FilterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $filterArray = $filterManager->getAsArray($filters, $metadataFactory);

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
        $filterCategoryClass = $this->container->getParameter('mesd_user.filter_category_class');
        $entity = new $filterClass();
        $form = $this->createForm(
            new FilterType($filterClass, $filterCategoryClass),
            $entity,
            array(
                'action' => $this->generateUrl('MesdUserBundle_filter_create'),
                'em' => $entityManager,
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
            $entityLists = $filterManager->getEntityLists($filterCategoryConfig['entities'], $metadataFactory);
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
        $entityManager = $this->getDoctrine()->getManager();
        $filterClass = $this->container->getParameter('mesd_user.filter_class');
        $filterCategoryClass = $this->container->getParameter('mesd_user.filter_category_class');
        $entity = new $filterClass();
        $form = $this->createForm(
            new FilterType($filterClass, $filterCategoryClass),
            $entity,
            array(
                'action' => $this->generateUrl('MesdUserBundle_filter_create'),
                'em' => $entityManager,
                'method' => 'POST',
            )
        );
        $form->add('create', 'submit', array(
            'label' => 'Create',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
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
        $filterArray = $filterManager->getAsArray($filters, $metadataFactory);

        return $this->render(
            $this->container->getParameter('mesd_user.filter.template.show'),
            array(
                'id' => $id,
                'filters' => $filterArray,
            )
        );
    }

    public function editAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $filterClass = $this->container->getParameter('mesd_user.filter_class');
        $filterRepository = $entityManager->getRepository($filterClass);
        $filters = $filterRepository->findById($id);
        $entity = $filterRepository->findOneById($id);
        $filterCategoryClass = $this->container->getParameter('mesd_user.filter_category_class');
        $filterCategory = $entity->getFilterCategory();
        $filterManager = $this->get('mesd_user.filter_manager');
        $metadataFactory = $entityManager->getMetadataFactory();
        $filterArray = $filterManager->getAsArray($filters, $metadataFactory);
        $config = $filterManager->getConfig();
        $filterCategoryName = $filterCategory->getName();
        $entityLists = array();
        if (array_key_exists($filterCategoryName, $config)) {
            $filterCategoryConfig = $config[$filterCategoryName];
            $entityLists = $filterManager->getEntityLists($filterCategoryConfig['entities'], $metadataFactory);
        } else {
            $filterCategoryConfig = null;
        }
        $form = $this->createForm(
            new FilterType($filterClass, $filterCategoryClass),
            $entity,
            array(
                'action' => $this->generateUrl('MesdUserBundle_filter_update', array('id' => $entity->getId())),
                'em' => $entityManager,
                'method' => 'POST',
            )
        );
        $form->add('update', 'submit', array(
            'label' => 'Update',
        ));

        return $this->render(
            $this->container->getParameter('mesd_user.filter.template.edit'),
            array(
                'filterCategoryConfig' => $filterCategoryConfig,
                'filters' => $filterArray,
                'form' => $form->createView(),
                'entityLists' => $entityLists,
            )
        );
    }

    public function updateAction(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $filterClass = $this->container->getParameter('mesd_user.filter_class');
        $filterRepository = $entityManager->getRepository($filterClass);
        $filters = $filterRepository->findById($id);
        $entity = $filterRepository->findOneById($id);
        $filterCategoryClass = $this->container->getParameter('mesd_user.filter_category_class');
        $filterCategory = $entity->getFilterCategory();
        $filterManager = $this->get('mesd_user.filter_manager');
        $metadataFactory = $entityManager->getMetadataFactory();
        $filterArray = $filterManager->getAsArray($filters, $metadataFactory);
        $config = $filterManager->getConfig();
        $filterCategoryName = $filterCategory->getName();
        $entityLists = array();
        if (array_key_exists($filterCategoryName, $config)) {
            $filterCategoryConfig = $config[$filterCategoryName];
            $entityLists = $filterManager->getEntityLists($filterCategoryConfig['entities'], $metadataFactory);
        } else {
            $filterCategoryConfig = null;
        }
        $form = $this->createForm(
            new FilterType($filterClass, $filterCategoryClass),
            $entity,
            array(
                'action' => $this->generateUrl('MesdUserBundle_filter_update', array('id' => $entity->getId())),
                'em' => $entityManager,
                'method' => 'POST',
            )
        );
        $form->add('update', 'submit', array(
            'label' => 'Update',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('MesdUserBundle_filter_show', array('id' => $entity->getId())));
        }

        return $this->render(
            $this->container->getParameter('mesd_user.filter.template.edit'),
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function eachUserAction()
    {
        return $this->render(
            $this->container->getParameter('mesd_user.filter.template.eachuser'),
            array(
            )
        );
    }

    public function allUsersAction()
    {
        return $this->render(
            $this->container->getParameter('mesd_user.filter.template.allusers'),
            array(
            )
        );
    }
}