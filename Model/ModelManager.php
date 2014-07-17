<?php

namespace DCS\TagBundle\Model;

use DCS\TagBundle\Urlizer\UrlizerInterface;

abstract class ModelManager implements ModelManagerInterface
{
    /**
     * @var string
     */
    protected $className;

    /**
     * @var \DCS\TagBundle\Urlizer\UrlizerInterface
     */
    protected $urlizer;

    function __construct($className, UrlizerInterface $urlizer)
    {
        $this->className = $className;
        $this->urlizer = $urlizer;
    }

    /**
     * Get class
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Create an empty tag instance
     *
     * @param string $value
     * @return TagInterface
     */
    public function create($value)
    {
        $class = $this->getClassName();

        /** @var $tag TagInterface */
        $tag = new $class();
        $tag->setName($value);
        $tag->setCode($this->urlizer->urlize($value, '_'));
        $tag->setSlug($this->urlizer->urlize($value, '-'));

        return $tag;
    }

    /**
     * Create a tag instance if not exists otherwise return
     *
     * @param string $value
     * @return TagInterface
     */
    public function add($value)
    {
        /** @var $tag TagInterface */
        $tag = $this->create($value);

        if (null !== $persistedTag = $this->findOneByCode($tag->getCode())) {
            $tag = $persistedTag;
        } else {
            $this->save($tag);
        }

        return $tag;
    }

    /**
     * Find one tag by code
     *
     * @param string $code
     * @return TagInterface
     */
    abstract protected function findOneByCode($code);
}