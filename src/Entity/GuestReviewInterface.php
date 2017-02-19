<?php

namespace Drupal\guest_reviews\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Guest review entities.
 *
 * @ingroup guest_reviews
 */
interface GuestReviewInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Guest review name.
   *
   * @return string
   *   Name of the Guest review.
   */
  public function getName();

  /**
   * Sets the Guest review name.
   *
   * @param string $name
   *   The Guest review name.
   *
   * @return \Drupal\guest_reviews\Entity\GuestReviewInterface
   *   The called Guest review entity.
   */
  public function setName($name);

  /**
   * Gets the Guest review creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Guest review.
   */
  public function getCreatedTime();

  /**
   * Sets the Guest review creation timestamp.
   *
   * @param int $timestamp
   *   The Guest review creation timestamp.
   *
   * @return \Drupal\guest_reviews\Entity\GuestReviewInterface
   *   The called Guest review entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Guest review published status indicator.
   *
   * Unpublished Guest review are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Guest review is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Guest review.
   *
   * @param bool $published
   *   TRUE to set this Guest review to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\guest_reviews\Entity\GuestReviewInterface
   *   The called Guest review entity.
   */
  public function setPublished($published);

}
