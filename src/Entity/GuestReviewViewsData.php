<?php

namespace Drupal\guest_reviews\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Guest review entities.
 */
class GuestReviewViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
