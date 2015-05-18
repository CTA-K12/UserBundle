<?php

namespace Mesd\UserBundle\Controller;

use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FilterController extends Controller
{
    public function indexAction()
    {
        $filterClass = $this->container->getParameter('mesd_user.filter_class');
        $filterRepository = $this->getDoctrine()->getManager()->getRepository($filterClass);
        $filters = $filterRepository->findAll();
        $filterManager = $this->get('mesd_user.filter_manager');
        $entityManager = $this->getDoctrine()->getManager();
        $metadataFactory = $entityManager->getMetadataFactory();

        $filterArray = array();
        foreach ($filters as $filter) {
            $solvents = $filter->getSolventWrappers();
            $solventArray = array();
            foreach ($solvents as $solvent) {
                foreach ($solvent->getBunch() as $bunch) {
                    foreach ($bunch->getEntity() as $entity) {
                        $metadata = $metadataFactory->getMetadataFor($entity->getName());
                        foreach ($entity->getJoin() as $join) {
                            $associationMetadata = $metadata;
                            $associations = $join->getAssociation();
                            $length = count($associations);
                            for ($i = 0; $i < $length; $i++) {
                                 $targetEntity = $associationMetadata->getAssociationMapping($associations[$i])['targetEntity'];
                                 $associationMetadata = $metadataFactory->getMetadataFor($targetEntity);
                            }
                            $entity = $entityManager->getRepository($associationMetadata->getName())->findOneById($join->getValue());
                            // var_dump($entity->__toString());
                            $solventArray[] = array(
                                'name' => $join->getName(),
                                'trail' => $join->getTrail(),
                                'item' => (string) $entity,
                            );
                        }
                    }
                }
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
}