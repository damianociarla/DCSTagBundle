<?php

namespace DCS\TagBundle\Doctrine;

use DCS\TagBundle\Model\ModelManager;
use DCS\TagBundle\Model\ObjectManager;
use DCS\TagBundle\Model\TagInterface;
use Doctrine\ORM\EntityManager;

class TagManager extends ModelManager
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Set ObjectManager
     *
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setManager(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Get ObjectManager
     *
     * @return ObjectManager
     */
    public function getManager()
    {
        return $this->em;
    }

    /**
     * Find one tag by code
     *
     * @param string $code
     * @return TagInterface|null
     */
    protected function findOneByCode($code)
    {
        return $this->em->getRepository($this->className)->findOneBy(array(
            'code' => $code,
        ));
    }

    /**
     * Save tag
     *
     * @param TagInterface $tag
     */
    public function save(TagInterface $tag)
    {
        $this->em->persist($tag);
        $this->em->flush();
    }
} 