<?php

namespace DCS\TagBundle\Model;

interface ModelManagerInterface
{
    /**
     * @return ObjectManager
     */
    public function getManager();
} 