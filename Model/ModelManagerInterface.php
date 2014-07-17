<?php

namespace DCS\TagBundle\Model;

interface ModelManagerInterface
{
    /**
     * Get ObjectManager
     *
     * @return ObjectManager
     */
    public function getManager();

    /**
     * Get class
     *
     * @return string
     */
    public function getClassName();

    /**
     * Create an empty tag instance
     *
     * @param string $value
     * @return TagInterface
     */
    public function create($value);

    /**
     * Create a tag instance if not exists otherwise return
     *
     * @param string $value
     * @return TagInterface
     */
    public function add($value);

    /**
     * Save tag
     *
     * @param TagInterface $tag
     */
    public function save(TagInterface $tag);
} 