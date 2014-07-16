<?php

namespace DCS\TagBundle\Urlizer;

interface UrlizerInterface
{
    /**
     * @param string $string
     * @param string $separator
     * @return string
     */
    public function urlize($string, $separator = '-');
} 