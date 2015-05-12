<?php

namespace Mesd\UserBundle\Model\Solvent;

/**
 * Join
 */
class Join {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $unique;

    /**
     * @var array
     */
    protected $association;

    /**
     * @var int
     */
    protected $id;

    public function __construct($name, $unique, $id)
    {
        $this->name = $name;
        $this->unique = $unique;
        $this->association = explode('->', $name);
        $this->id = (int)$id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get association
     *
     * @return array
     */
    public function getAssociation()
    {
        return $this->association;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function applyToQueryBuilder($alias, $queryBuilder)
    {
        $associations = $this->association;
        $length = count($associations);
        if (1 === $length) {
            $queryBuilder->join(
                $alias . '.' . $associations[0],
                $this->unique . $associations[0],
                'WITH',
                $this->unique . $associations[0] . '.id = ' . $this->id
            );
        } else {
            $queryBuilder->join($alias . '.' . $associations[0], $this->unique . $associations[0]);
        }
        for ($i = 1; $i < $length; $i++) {
            if ($i === $length - 1) {
                $queryBuilder->join(
                    $this->unique . $associations[$i - 1] . '.' . $associations[$i],
                    $this->unique . $associations[$i],
                    'WITH',
                    $this->unique . $associations[0] . '.id = ' . $this->id
                );
            } else {
                $queryBuilder->join($this->unique . $associations[$i - 1] . '.' . $associations[$i], $this->unique . $associations[$i]);
            }
        }

        return $queryBuilder;
    }
}
