<?php

namespace Mesd\UserBundle\Model\Solvent;

/**
 * Entity
 */
class Entity {

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
    protected $join;

    public function __construct($name, $unique, $joins)
    {
        $this->name = $name;
        $this->unique = $unique;
        $this->join = array();
        $length = count($joins);
        $i = 0;
        foreach($joins as $joinName => $joinId) {
            $this->join[] = new Join($joinName, $unique . 'join' . $i, $joinId);
            $i++;
        }
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
     * Get join
     *
     * @return array
     */
    public function getJoin()
    {
        return $this->join;
    }

    public function applyToQueryBuilder($queryBuilder)
    {
        foreach ($queryBuilder->getDQLParts() as $partName => $parts) {
            if (false !== $parts && !is_null($parts) && !empty($parts)) {
                foreach ($parts as $part) {
                    if ('select' === $partName) {
                    } elseif ('from' === $partName) {
                        if ($this->name === $part->getFrom()) {
                            foreach ($this->join as $join) {
                                $queryBuilder = $join->applyToQueryBuilder($part->getAlias(), $queryBuilder);
                            }
                        }
                    } elseif ('join' === $partName) {
                        foreach ($part as $partJoin) {
                            if ($this->name === $partJoin->getJoin()) {
                                foreach ($this->join as $join) {
                                    $queryBuilder = $join->applyToQueryBuilder($partJoin->getAlias(), $queryBuilder);
                                }
                            }
                        }
                    }
                }
            }
        }

        return $queryBuilder;
    }
}
