<?php

namespace Drupal\octophin_helpers\TwigExtension;

use Drupal\octophin_helpers\MediaHelpers;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;



class MediaTwigHelpers extends AbstractExtension
{

    public function getName()
    {
        return 'octophin_helpers.media_twig_extension';
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('get_image_from_media_field', [MediaHelpers::class, 'getImageFromMediaField'])
        ];
    }


}
