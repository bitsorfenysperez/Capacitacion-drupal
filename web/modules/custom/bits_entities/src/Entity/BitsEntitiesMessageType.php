<?php

namespace Drupal\bits_entities\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Bits Entities Message type entity.
 *
 * @ConfigEntityType(
 *   id = "bits_entities_message_type",
 *   label = @Translation("Bits Entities Message type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\bits_entities\BitsEntitiesMessageTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\bits_entities\Form\BitsEntitiesMessageTypeForm",
 *       "edit" = "Drupal\bits_entities\Form\BitsEntitiesMessageTypeForm",
 *       "delete" = "Drupal\bits_entities\Form\BitsEntitiesMessageTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\bits_entities\BitsEntitiesMessageTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "bits_entities_message_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "bits_entities_message",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/bits_entities_message_type/{bits_entities_message_type}",
 *     "add-form" = "/admin/structure/bits_entities_message_type/add",
 *     "edit-form" = "/admin/structure/bits_entities_message_type/{bits_entities_message_type}/edit",
 *     "delete-form" = "/admin/structure/bits_entities_message_type/{bits_entities_message_type}/delete",
 *     "collection" = "/admin/structure/bits_entities_message_type"
 *   }
 * )
 */
class BitsEntitiesMessageType extends ConfigEntityBundleBase implements BitsEntitiesMessageTypeInterface {

  /**
   * The Bits Entities Message type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Bits Entities Message type label.
   *
   * @var string
   */
  protected $label;

}
