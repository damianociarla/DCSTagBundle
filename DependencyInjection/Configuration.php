<?php

namespace DCS\TagBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dcs_tag');

        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->defaultValue('orm')
                    ->validate()
                    ->ifNotInArray(array('orm'))
                        ->thenInvalid('Value "%s" is not a valid db_driver')
                    ->end()
                ->end()
                ->scalarNode('model')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('urlizer')
                    ->cannotBeEmpty()
                    ->defaultValue('dcs_tag.urlizer.default')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
