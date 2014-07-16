<?php

namespace DCS\TagBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\DataTransformerInterface;

class TagFormType extends AbstractType
{
    protected $dataTransformer;

    function __construct(DataTransformerInterface $dataTransformer)
    {
        $this->dataTransformer = $dataTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer($this->dataTransformer, true);
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'dcs_tag';
    }
} 