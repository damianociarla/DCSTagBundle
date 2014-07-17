<?php

namespace DCS\TagBundle\Form\DataTransformer;

use DCS\TagBundle\Model\ModelManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

class TextToArrayTagTransformer implements DataTransformerInterface
{
    /**
     * @var \DCS\TagBundle\Model\ModelManagerInterface
     */
    protected $manager;

    function __construct(ModelManagerInterface $modelManager)
    {
        $this->manager = $modelManager;
    }

    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        if (!($value instanceof Collection)) {
            throw new UnexpectedTypeException($value, 'Doctrine\Common\Collections\Collection');
        }

        return implode(',', $value->toArray());
    }

    public function reverseTransform($value)
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $values = explode(',', $value);
        $tags = new ArrayCollection();

        foreach ($values as $value) {
            $tags->add($this->manager->add($value));
        }

        return $tags;
    }
} 