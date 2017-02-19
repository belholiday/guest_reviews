<?php

namespace Drupal\guest_reviews\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Guest review entity.
 *
 * @ingroup guest_reviews
 *
 * @ContentEntityType(
 *   id = "guest_review",
 *   label = @Translation("Guest review"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\guest_reviews\GuestReviewListBuilder",
 *     "views_data" = "Drupal\guest_reviews\Entity\GuestReviewViewsData",
 *     "translation" = "Drupal\guest_reviews\GuestReviewTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\guest_reviews\Form\GuestReviewForm",
 *       "add" = "Drupal\guest_reviews\Form\GuestReviewForm",
 *       "edit" = "Drupal\guest_reviews\Form\GuestReviewForm",
 *       "delete" = "Drupal\guest_reviews\Form\GuestReviewDeleteForm",
 *     },
 *     "access" = "Drupal\guest_reviews\GuestReviewAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\guest_reviews\GuestReviewHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "guest_review",
 *   data_table = "guest_review_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer guest review entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/guest-reviews/{guest_review}",
 *     "add-form" = "/admin/structure/guest_review/add",
 *     "edit-form" = "/admin/structure/guest_review/{guest_review}/edit",
 *     "delete-form" = "/admin/structure/guest_review/{guest_review}/delete",
 *     "collection" = "/admin/structure/guest_review",
 *   },
 *   field_ui_base_route = "guest_review.settings"
 * )
 */
class GuestReview extends ContentEntityBase implements GuestReviewInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Guest review entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'hidden',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 15,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Label'))
      //->setDescription(t('The name of the Guest review entity.'))
      ->setSettings(array(
        'max_length' => 250,
        'text_processing' => 0,
      ))
      ->setRequired(TRUE)
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['review'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Review'))
      //->setDescription(t('A Recall.'))
      ->setTranslatable(TRUE)
      ->setRequired(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'text_default',
        'weight' => 0,
      ))
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form', array(
        'type' => 'text_textfield',
        'weight' => 0,
      ))
      ->setDisplayConfigurable('form', TRUE);
    $fields['email'] = BaseFieldDefinition::create('email')
      ->setLabel(t('E-mail'))
      ->setDescription(t('Feedback e-mail'))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', array(
        'type' => 'email_default',
        'weight' => 5,
      ))
      ->setRequired(TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['telephone'] = BaseFieldDefinition::create('telephone')
      ->setLabel(t('Telephone'))
      //->setDescription((t('The phone number')))
      ->setDefaultValue('')
      ->setDisplayOptions('form', array(
        'type' => 'telephone_default',
        'weight' => 0,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Guest review is published.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
