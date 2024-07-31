<?php

namespace Drupal\octophin_helpers;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
use Drupal\media\Entity\Media;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Url;

class MediaHelpers
{

    public static function getVideoUrlFromMediaField(FieldItemListInterface $field): ?string
    {


        if ($field->isEmpty()) {

            return null;
        }

        if (!$field->entity) {

            return null;
        }

        $fid = $field->entity->get("field_media_video_file")->target_id;

        $file = File::load($fid);

        return \Drupal::service('file_url_generator')
            ->generateAbsoluteString($file->getFileUri());

    }

    public static function getImageFromMediaField(FieldItemListInterface $field, string $image_style): ?string
    {

        if ($field->isEmpty()) {

            return null;
        }

        if (!$field->entity) {

            return null;
        }

        $fid = $field->entity->get("field_media_image")->target_id;

        $file = File::load($fid);

        $uri = $file->getFileUri();

        $style = ImageStyle::load($image_style);

        $url = $style->buildUrl($uri);

        return $url;
    }

    public static function create_media_video_from_url(string $url, string $name): Media
    {

        $video_data = file_get_contents($url);
        $file_repository = \Drupal::service('file.repository');
        $video = $file_repository->writeData($video_data, "public://" . basename($url), FileSystemInterface::EXISTS_REPLACE);

        $video_media = Media::create([
            'name' => $name,
            'bundle' => 'video',
            'uid' => 1,
            'status' => 1,
            'field_media_video_file' => [
                'target_id' => $video->id()
            ]
        ]);

        $video_media->save();

        return $video_media;
    }

    public static function create_media_image_from_url(string $url, string $name): Media
    {

        $image_data = file_get_contents($url);
        $file_repository = \Drupal::service('file.repository');
        $image = $file_repository->writeData($image_data, "public://" . basename($url), FileSystemInterface::EXISTS_REPLACE);

        $image_media = Media::create([
            'name' => $name,
            'bundle' => 'image',
            'uid' => 1,
            'status' => 1,
            'field_media_image' => [
                'target_id' => $image->id()
            ]
        ]);
        $image_media->save();

        return $image_media;
    }

}
