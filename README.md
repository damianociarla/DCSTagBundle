DCSTagBundle
============

**DCSTagBundle** adds tagging to your Symfony project, with the ability to associate tags with any number of different entities.

## Installation

### a) Download and install DCSTagBundle

To install DCSTagBundle run the following command

	bash $ php composer.phar require damianociarla/tag-bundle

### b) Enable the bundle

To enable it add the bundle instance in the kernel:

	<?php
	// app/AppKernel.php

	public function registerBundles()
	{
	    $bundles = array(
        	// ...
        	new DCS\TagBundle\DCSTagBundle(),
    	);
	}

## 2) Create your Tag classes

In this first release DCSTagBundle supports only Doctrine ORM. However, you must provide a concrete Tag class.
You must extend the abstract entity provided by the bundle and creating the appropriate mapping.

### a) Annotation

    <?php
    // src/Acme/TagBundle/Entity/Tag.php

    namespace Acme\TagBundle\Entity;

    use DCS\TagBundle\Entity\Tag as BaseTag;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity
     * @ORM\Table(name="tag")
     */
    class Tag extends BaseTag
    {

    }

### b) xml

    <?php
    // src/Acme/TagBundle/Entity/Tag.php

    namespace Acme\TagBundle\Entity;

    use DCS\TagBundle\Entity\Tag as BaseTag;

    class Tag extends BaseTag
    {

    }

XML mapping file

    <!-- src/Acme/TagBundle/Resources/config/doctrine/Tag.orm.xml -->

    <?xml version="1.0" encoding="UTF-8"?>

    <doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                      xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

        <entity name="Acme\TagBundle\Entity\Tag" table="tag__tags" />

    </doctrine-mapping>

## 3) Configure your application

	# app/config/config.yml

    dcs_tag:
        db_driver: orm
        model: Acme\TagBundle\Entity\Tag

## 4) Add relationships to your Entity classes

    <?php
    // src/Acme/BlogBundle/Entity/Post.php

    namespace Acme\BlogBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity
     * @ORM\Table(name="post")
     */
    class Post
    {
        //... stuff

        /**
         * @ORM\ManyToMany(targetEntity="Acme\TagBundle\Entity\Tag", cascade={"remove", "persist"})
         * @ORM\JoinTable(name="post_has_tag",
         *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
         *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
         *      )
         */
        protected $tags;

        function __construct()
        {
            //... stuff

            $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        }

        /**
         * Add tag
         *
         * @param \DCS\TagBundle\Model\TagInterface $tag
         * @return Post
         */
        public function addTag(\DCS\TagBundle\Model\TagInterface $tag)
        {
            $this->tags[] = $tag;

            return $this;
        }

        /**
         * Remove tag
         *
         * @param \DCS\TagBundle\Model\TagInterface $tag
         */
        public function removeTag(\DCS\TagBundle\Model\TagInterface $tag)
        {
            $this->tags->removeElement($tag);
        }

        /**
         * Get tags
         *
         * @return \Doctrine\Common\Collections\Collection
         */
        public function getTags()
        {
            return $this->tags;
        }
    }

## 5) Use the "dcs_tag" form type

    <?php
    // src/Acme/BlogBundle/Form/Type/PostFormType.php

    namespace Acme\BlogBundle\Form\Type;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;

    class PostFormType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
                //... stuff
                ->add('tags', 'dcs_tag')
            ;
        }
    }

## 6) How to save tags

If you use the form you don't need the Tag model manager (`dcs_tag.manager`) to persist the entity because it's already managed by DataTransformer, but if you want manually add a single tag to a collection, you can use the following code:

    $tagManager = $this->container->get('dcs_tag.manager');

    $post = new Post();
    $post->addTag($tagManager->add('tag-to-add'));

    //... persist the post object

The `add` method inserts a new tag, if already doesn’t exists, otherwise it returns the found tag.