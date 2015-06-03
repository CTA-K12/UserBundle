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
    protected $trail;

    /**
     * @var string
     */
    protected $unique;

    /**
     * @var array
     */
    protected $association;

    /**
     * @var string
     */
    protected $value;

    public function __construct($name, $trail, $unique, $value)
    {
        $this->name = $name;
        $this->trail = $trail;
        $this->unique = $unique;
        $this->association = explode('->', $trail);
        $this->value = $value;
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
     * Get trail
     *
     * @return string
     */
    public function getTrail()
    {
        return $this->trail;
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
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    public function applyToQueryBuilder($alias, $queryBuilder, $details)
    {
        $associations = $this->association;
        $length = count($associations);
        if ('' === $details) {
            if ('id' == $this->trail) {
            } elseif (1 === $length) {
                $queryBuilder->join(
                    $alias . '.' . $associations[0],
                    $this->unique . $associations[0]
                );
            } else {
                $queryBuilder->join($alias . '.' . $associations[0], $this->unique . $associations[0]);
            }
            for ($i = 1; $i < $length; $i++) {
                $queryBuilder->join(
                    $this->unique . $associations[$i - 1] . '.' . $associations[$i],
                    $this->unique . $associations[$i]
                );
            }
        } else {
            if ('id' == $this->trail) {
                $queryBuilder->andWhere($details);
            } elseif (1 === $length) {
                $queryBuilder->join(
                    $alias . '.' . $associations[0],
                    $this->unique . $associations[0],
                    'WITH',
                    $details
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
                        $details
                    );
                } else {
                    $queryBuilder->join($this->unique . $associations[$i - 1] . '.' . $associations[$i], $this->unique . $associations[$i]);
                }
            }
        }

        return $queryBuilder;
    }

    public function getDetails($alias)
    {
        if ('id' == $this->trail) {
            return '(' . $alias . '.id = ' . $this->value . ')';
        } else {
            $length = count($this->association);
            $lastAssociation = $this->unique . $this->association[$length - 1];

            return '(' . $lastAssociation . '.id = ' . $this->value . ')';
        }
    }
}
