<?php

namespace Drupal\bits_entities\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Bits Entities Message entity.
 *
 * @ingroup bits_entities
 *
 * @ContentEntityType(
 *   id = "bits_entities_message",
 *   label = @Translation("Bits Entities Message"),
 *   bundle_label = @Translation("Bits Entities Message type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\bits_entities\BitsEntitiesMessageListBuilder",
 *     "views_data" = "Drupal\bits_entities\Entity\BitsEntitiesMessageViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\bits_entities\Form\BitsEntitiesMessageForm",
 *       "add" = "Drupal\bits_entities\Form\BitsEntitiesMessageForm",
 *       "edit" = "Drupal\bits_entities\Form\BitsEntitiesMessageForm",
 *       "delete" = "Drupal\bits_entities\Form\BitsEntitiesMessageDeleteForm",
 *     },
 *      "access" = "Drupal\bits_entities\BitsEntitiesMessageAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\bits_entities\BitsEntitiesMessageHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "bits_entities_message",
 *   translatable = FALSE,
 *   admin_permission = "administer bits entities message entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "subject",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/bits_entities_message/{bits_entities_message}",
 *     "add-page" = "/admin/structure/bits_entities_message/add",
 *     "add-form" = "/admin/structure/bits_entities_message/add/{bits_entities_message_type}",
 *     "edit-form" = "/admin/structure/bits_entities_message/{bits_entities_message}/edit",
 *     "delete-form" = "/admin/structure/bits_entities_message/{bits_entities_message}/delete",
 *     "collection" = "/admin/structure/bits_entities_message",
 *   },
 *   bundle_entity_type = "bits_entities_message_type",
 *   field_ui_base_route = "entity.bits_entities_message_type.edit_form"
 * )
 */
class BitsEntitiesMessage extends ContentEntityBase implements BitsEntitiesMessageInterface {

  use EntityChangedTrait;
  
  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return $this->bundle();
  }

  /**
   * {@inheritdoc}
   */
  public function getSubject() {
    return $this->get('subject')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setSubject($subject) {
    $this->set('subject', $subject);
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
  public function setPublished($Published = NULL) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

   /**
   * {@inheritdoc}
   */
  public function setUnpublished() {
    $key = $this->getEntityType()->getKey('published');
    $this->set($key, FALSE);

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getUserToId() {
    return $this->get('user_to')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setUserToId($uid) {
    $this->set('user_to', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getUserTo(){
    return $this->get('user_to')->entity;
  }


  /**
   * {@inheritdoc}
   */
  public function getContent(){
    return $this->get('content')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setContent($content){
    $this->set('content', $content);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isRead(){
    return (bool) $this->getEntityKey('is_read');
  }

  /**
   * {@inheritdoc}
   */
  public function setRead($read){
    $this->set('is_read', $read ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Bits Entities Message entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

      $fields['user_to'] = BaseFieldDefinition::create('entity_reference')
        ->setLabel(t('To'))
        ->setDescription(t('The user ID of the Bits Entities Message recipient.'))
        ->setRevisionable(TRUE)
        ->setSetting('target_type', 'user')
        ->setSetting('handler', 'default')
        ->setTranslatable(TRUE)
        ->setDisplayOptions('view', [
          'label' => 'To',
          'type' => 'author',
          'weight' => 0,
        ])
        ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
        ])
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

    $fields['subject'] = BaseFieldDefinition::create('string')
        ->setLabel(t('Subject'))
        ->setDescription(t('The subject of the Bits Entities Message entity.'))
        ->setSettings([
          'max_length' => 100,
          'text_processing' => 0,
        ])
        ->setDefaultValue('')
        ->setDisplayOptions('view',[
          'label' => 'above',
          'type' => 'string',
          'weight' => -4,
        ])
        ->setDisplayOptions('form',[
          'type' => 'string_textfield',
          'weight' => -4,
        ])
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

    $fields['content'] = BaseFieldDefinition::create('text_long')
        ->setLabel(t('Content'))
        ->setDescription(t('The content of the Bits Entities Message'))
        ->setTranslatable(TRUE)
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
    
    $fields['is_read'] = BaseFieldDefinition::create('boolean')
        ->setLabel(t('Read'))
        ->setDescription(t('A boolean indicating whether the Bits Entities Message is read.'))
        ->setDefaultValue(FALSE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
        ->setLabel(t('Publishing status'))
        ->setDescription(t('A boolean indicating whether the Bits Entities Message is published.'))
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
