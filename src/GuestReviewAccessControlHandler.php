<?php

namespace Drupal\guest_reviews;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Guest review entity.
 *
 * @see \Drupal\guest_reviews\Entity\GuestReview.
 */
class GuestReviewAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\guest_reviews\Entity\GuestReviewInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished guest review entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published guest review entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit guest review entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete guest review entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add guest review entities');
  }

}
