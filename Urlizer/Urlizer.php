<?php

namespace DCS\TagBundle\Urlizer;

use Ferrandini\Urlizer as UrlizerManager;

class Urlizer implements UrlizerInterface
{
    /**
     * @param string $string
     * @param string $separator
     * @return string
     */
    public function urlize($string, $separator = '-')
    {
        return UrlizerManager::urlize($string, $separator);
    }
} 