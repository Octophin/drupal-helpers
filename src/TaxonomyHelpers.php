<?php

namespace Drupal\octophin_helpers;

use Drupal\taxonomy\Entity\Term;

class TaxonomyHelpers
{
    
    public static function get_term_by_name(string $vocabulary, string $name): ?Term
    {

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

    public static function upsert_term(string $vocabulary, string $name): Term
    {

        $existing = self::get_term_by_name($vocabulary, $name);

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
}
