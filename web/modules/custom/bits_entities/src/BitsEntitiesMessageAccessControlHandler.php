<?php

namespace Drupal\bits_entities;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Bits Entities Message entity.
 *
 * @see \Drupal\bits_entities\Entity\BitsEntitiesMessage.
 */
class BitsEntitiesMessageAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\bits_entities\Entity\BitsEntitiesMessageInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished bits entities message entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published bits entities message entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit bits entities message entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete bits entities message entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add bits entities message entities');
  }


}
