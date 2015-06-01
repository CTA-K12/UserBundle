<?php

namespace Mesd\UserBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class SolventToJsonTransformer implements DataTransformerInterface
{

    /**
     * Transforms an array (solventArray) to a string (json).
     *
     * @param  array $solventArray
     * @return string
     */
    public function transform($solventArray)
    {
        return json_encode($solventArray);
    }

    /**
     * Transforms a string (json) to an array (solventString).
     *
     * @param  string $solventString
     *
     * @return array
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($solventString)
    {
        return json_decode($solventString);
    }
}