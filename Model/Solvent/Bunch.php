<?php

namespace Mesd\UserBundle\Model\Solvent;

/**
 * Bunch
 */
class Bunch {

    /**
     * @var string
     */
    protected $unique;

    /**
     * @var array
     */
    protected $entity;

    public function __construct($unique, $entities)
    {
        $this->unique = $unique;
        $this->entity = array();
        $length = count($entities);
        for ($i = 0; $i < $length; $i++) {
            $this->entity[] = new Entity($entities[$i]['name'], 'entity' . $i, $entities[$i]['joins']);
        }
    }

    /**
     * Get entity
     *
     * @return array
     */
    public function getEntity()
    {
        return $this->entity;
    }

    public function applyToQueryBuilder($queryBuilder, $details)
    {
        $length = count($this->entity);
        for ($i = 0; $i < $length; $i++) {
            if (($length - 1) === $i) {
                $this->entity[$i]->applyToQueryBuilder($queryBuilder, $details);
            } else {
                $this->entity[$i]->applyToQueryBuilder($queryBuilder, '');
            }
        }

        return $queryBuilder;
    }

    public function getDetails()
    {
        $details = array();
        foreach($this->entity as $entity) {
            $details[] = $entity->getDetails();
        }

        return '(' . implode(' AND ', $details) . ')';
    }
}
