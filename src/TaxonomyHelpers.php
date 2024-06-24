<?php

namespace Drupal\octophin_helpers;

use Drupal\taxonomy\Entity\Term;

class TaxonomyHelpers
{

    public static function get_term_by_name(string $vocabulary, string $name, bool $cleanup = false): ?Term
    {

        if ($cleanup) {
          $name = self::cleanup_term_name($name);
        }

        $result = \Drupal::entityQuery('taxonomy_term')
            ->condition('vid', $vocabulary)
            ->condition('name', $name)
            ->accessCheck(true)
            ->execute();

        if (count($result)) {
            return Term::load(current($result));
        } else {
            return null;
        }
    }

    public static function upsert_term(string $vocabulary, string $name, bool $cleanup = false): Term
    {

        if ($cleanup) {
          $name = self::cleanup_term_name($name);
        }

        $existing = self::get_term_by_name($vocabulary, $name, $cleanup);

        if ($existing) {

            return $existing;
        }

        $term = Term::create([
            "vid" => $vocabulary,
            "name" => $name
        ]);

        $term->save();

        return $term;
    }

  public static function cleanup_term_name(string $termName): String
  {
    $termName = trim(str_replace(['_', '  '], [' ', ' '], $termName));
    return $termName;
  }
}
