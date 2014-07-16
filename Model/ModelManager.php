<?php

namespace DCS\TagBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;

class ModelManager implements ModelManagerInterface
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $em;

    function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return ObjectManager
     */
    public function getManager()
    {
        return $this->em;
    }
}