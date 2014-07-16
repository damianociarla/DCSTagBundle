<?php

namespace DCS\TagBundle\Form\DataTransformer;

use DCS\TagBundle\Model\ModelManagerInterface;
use DCS\TagBundle\Model\TagInterface;
use DCS\TagBundle\Urlizer\UrlizerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

class TextToArrayTagTransformer implements DataTransformerInterface
{
    /**
     * @var \DCS\TagBundle\Model\ObjectManager
     */
    protected $manager;

    /**
     * @var \DCS\TagBundle\Urlizer\UrlizerInterface
     */
    protected $urlizer;

    /**
     * @var string
     */
    protected $modelClass;

    function __construct(ModelManagerInterface $modelManager, UrlizerInterface $urlizer, $modelClass)
    {
        $this->manager = $modelManager->getManager();
        $this->urlizer = $urlizer;
        $this->modelClass = $modelClass;
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
            $modelClass = $this->modelClass;

            /** @var $tag TagInterface */
            $tag = new $modelClass();
            $tag->setName($value);
            $tag->setCode($this->urlizer->urlize($value, '_'));
            $tag->setSlug($this->urlizer->urlize($value, '-'));

            $persistedTag = $this->manager->getRepository($modelClass)->findOneBy(array(
                'code' => $tag->getCode(),
            ));

            if (null !== $persistedTag) {
                $tag = $persistedTag;
            }

            $tags->add($tag);
        }

        return $tags;
    }
} 