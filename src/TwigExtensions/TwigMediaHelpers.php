<?php

namespace Drupal\octophin_helpers\TwigExtensions;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\octophin_helpers\MediaHelpers;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;


class TwigMediaHelpers extends AbstractExtension
{

    public function getName()
    {
        return 'octophin_helpers.twig_media_helpers';
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('twigtest', [$this, 'test']),
            new TwigFunction('twigGetImageFromMediaField', [$this, 'twigGetImageFromMediaField']),
            new TwigFunction('twigGetFieldsFromMediaField', [$this, 'twigGetFieldsFromMediaField']),

        ];
    }

    public function test()
    {
        return "test";  
    }

    public function twigGetImageFromMediaField(FieldItemListInterface $field, string $image_style)
    {
        return MediaHelpers::getImageFromMediaField($field, $image_style);  
    }

    public function twigGetFieldsFromMediaField($field, string $image_style = 'large')
    {
        return MediaHelpers::getFieldsFromMedia($field, $image_style);
    }

    
}
