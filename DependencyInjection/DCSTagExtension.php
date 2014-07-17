<?php

namespace DCS\TagBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class DCSTagExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $container->setParameter('dcs_tag.db_driver', $config['db_driver']);
        $container->setParameter('dcs_tag.model.class', $config['model']);

        $container->setAlias('dcs_tag.urlizer', $config['urlizer']);

        $loader->load('model.xml');
        $loader->load(sprintf('%s.xml', $config['db_driver']));

        $container->setAlias('dcs_tag.manager', 'dcs_tag.model.manager.default');

        $loader->load('form.xml');
        $loader->load('urlizer.xml');
    }
}
