<?php

namespace Drupal\guest_reviews;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Guest review entities.
 *
 * @ingroup guest_reviews
 */
class GuestReviewListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['name'] = $this->t('Name');
    $header['telephone'] = $this->t('Telephone');
    $header['email'] = $this->t('E-mail');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\guest_reviews\Entity\GuestReview */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.guest_review.edit_form', array(
          'guest_review' => $entity->id(),
        )
      )
    );
    $row['telephone'] = $entity->label();
    $row['email'] = $entity->label();
    return $row + parent::buildRow($entity);
  }

}
