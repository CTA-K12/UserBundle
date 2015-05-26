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
        for($i = 0; $i < $length; $i++) {
            $this->join[] = new Join($joins[$i]['name'], $joins[$i]['trail'], $unique, $joins[$i]['value']);
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

    public function applyToQueryBuilder($queryBuilder, $details)
    {
        foreach ($queryBuilder->getDQLParts() as $partName => $parts) {
            if (false !== $parts && !is_null($parts) && !empty($parts)) {
                foreach ($parts as $part) {
                    if ('select' === $partName) {
                    } elseif ('from' === $partName) {
                        if ($this->name === $part->getFrom()) {
                            $length = count($this->join);
                            for ($i = 0; $i < $length; $i++) {
                                if (($length - 1) === $i) {
                                    $queryBuilder = $this->join[$i]->applyToQueryBuilder($part->getAlias(), $queryBuilder, $details);
                                } else {
                                    $queryBuilder = $this->join[$i]->applyToQueryBuilder($part->getAlias(), $queryBuilder, '');
                                }
                            }
                        }
                    } elseif ('join' === $partName) {
                        foreach ($part as $partJoin) {
                            if ($this->name === $partJoin->getJoin()) {
                                $length = count($this->join);
                                for ($i = 0; $i < $length; $i++) {
                                    if (($length - 1) === $i) {
                                        $queryBuilder = $join[$i]->applyToQueryBuilder($partJoin->getAlias(), $queryBuilder, $details);
                                    } else {
                                        $queryBuilder = $join[$i]->applyToQueryBuilder($partJoin->getAlias(), $queryBuilder, '');
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $queryBuilder;
    }

    public function getDetails()
    {
        $details = array();
        foreach($this->join as $join) {
            $details[] = $join->getDetails();
        }

        return '(' . implode(' AND ', $details) . ')';
    }
}
