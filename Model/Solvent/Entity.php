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

    /**
     * @var array
     */
    protected $joinNames;

    /**
     * @var array
     */
    protected $joinChecks;


    public function __construct($name, $unique, $joins)
    {
        $this->name = $name;
        $this->unique = $unique;
        $this->join = array();
        $this->joinNames = array();
        $length = count($joins);
        for ($i = 0; $i < $length; $i++) {
            $this->join[] = new Join($joins[$i]['name'], $joins[$i]['trail'], $unique, $joins[$i]['value']);
            if ('id' === $joins[$i]['trail']) {
            } else {
                $trail = explode('->', $joins[$i]['trail']);
                $trailJoins = array();

                $trailLength = count($trail);
                for ($j = 0; $j < $trailLength; $j++) {
                    if (0 === $j) {
                        $previous = 'entity';
                    } else {
                        $previous = $trail[$j - 1];
                    }
                    $previous .= '.';
                    $trailJoins[] = $previous . $trail[$j];
                }

                $this->joinNames = array_merge(array_unique(array_merge($this->joinNames, $trailJoins)), array());
            }
        }
        $this->joinChecks = array();
        $length = count($this->joinNames);
        for ($i = 0; $i < $length; $i++) {
            $key = $this->joinNames[$i];
            $this->joinChecks[$key] = false;
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
                                    $queryBuilder = $this->join[$i]->applyToQueryBuilder($part->getAlias(), $queryBuilder, $details, $this);
                                } else {
                                    $queryBuilder = $this->join[$i]->applyToQueryBuilder($part->getAlias(), $queryBuilder, '', $this);
                                }
                            }
                        }
                    } elseif ('join' === $partName) {
                        foreach ($part as $partJoin) {
                            if ($this->name === $partJoin->getJoin()) {
                                $length = count($this->join);
                                for ($i = 0; $i < $length; $i++) {
                                    if (($length - 1) === $i) {
                                        $queryBuilder = $join[$i]->applyToQueryBuilder($partJoin->getAlias(), $queryBuilder, $details, $this);
                                    } else {
                                        $queryBuilder = $join[$i]->applyToQueryBuilder($partJoin->getAlias(), $queryBuilder, '', $this);
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

    public function getDetails($alias)
    {
        $details = array();
        foreach($this->join as $join) {
            $details[] = $join->getDetails($alias);
        }

        return '(' . implode(' AND ', $details) . ')';
    }

    public function getCheckedJoin($joinName = null)
    {
        if (is_null($joinName)) {

            return $this->joinChecks;
        }

        if (array_key_exists($joinName, $this->joinChecks)) {
            return $this->joinChecks[$joinName];
        } else {
            return null;
        }
    }

    public function setCheckedJoin($joinName, $value)
    {
        if (array_key_exists($joinName, $this->joinChecks)) {
            $this->joinChecks[$joinName] = $value;
        }
    }
}
