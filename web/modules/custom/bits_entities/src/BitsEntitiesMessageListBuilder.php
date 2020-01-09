<?php

namespace Drupal\bits_entities;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;


/**
 * Defines a class to build a listing of Bits Entities Message entities.
 *
 * @ingroup bits_entities
 */
class BitsEntitiesMessageListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Bits Entities Message ID');
    $header['from'] = $this->t('From');
    $header['to'] = $this->t('To');
    $header['subject'] = $this->t('Subject');
   
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\bits_entities\Entity\BitsEntitiesMessage  */
    $row['id'] = $entity->id();
    $row['from'] = $entity->getOwner()->getAccountName();
    $row['to'] = $entity->getUserTo()->getAccountName();

    $row['subject'] = $this->l(
      $entity->label(),
      new Url(
      'entity.bits_entities_message.edit_form',[
        'bits_entities_message' => $entity->id()
        ])
    );
  
    return $row + parent::buildRow($entity);
  }

}
