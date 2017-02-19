<?php

/**
 * @file
 * Contains guest_review.page.inc.
 *
 * Page callback for Guest review entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Guest review templates.
 *
 * Default template: guest_review.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_guest_review(array &$variables) {
  // Fetch GuestReview Entity Object.
  $guest_review = $variables['elements']['#guest_review'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
