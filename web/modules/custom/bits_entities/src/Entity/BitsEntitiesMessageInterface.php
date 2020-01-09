<?php

namespace Drupal\bits_entities\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Bits Entities Message entities.
 *
 * @ingroup bits_entities
 */
interface BitsEntitiesMessageInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

   /**
    * Gets the Bits Entities Message type.
    *
    * @return string
    *  The Bits Entities Message type.
    */
  public function getType();

  /**
   * Gets the Bits Entities Message subject. 
   * 
   * @return string
   *  Subject pf the Bits Entities Message. 
   */
  public function getSubject();

  /**
   * Sets the Bits Entities Message subject. 
   * 
   * @param string $subject
   *  The Bits Entities Message subject. 
   * 
   * @return \Drupal\bits_entities\Entity\BitsEntitiesMessageInterface
   *  The called Bits Entities Message entity. 
   */
  public function setSubject($subject);

  /**
   * Gets the Bits Entities Message creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Bits Entities Message.
   */
  public function getCreatedTime();

  /**
   * Sets the Bits Entities Message creation timestamp.
   *
   * @param int $timestamp
   *   The Bits Entities Message creation timestamp.
   *
   * @return \Drupal\bits_entities\Entity\BitsEntitiesMessageInterface
   *   The called Bits Entities Message entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Bits Entities Message published status indicator.
   * 
   * Unpublished Bits Entities Message are only visible to restricted users.
   * 
   * @return bool
   *  TRUE if the Bits Entities Message is published. 
   */
  public function isPublished();

  /**
   * Sets the published status of a Bits Entities Message.
   * 
   * @param bool $published
   *  TRUE to set this Bits Entities Message to published, FALSE to set it to unpublished. 
   * 
   * @return \Drupal\bits_entities\Entity\BitsEntitiesMessageInterface
   *  The called Bits Entities Message entity.
   */
  public function setPublished($published = NULL);

   /**
   * Sets the entity as unpublished.
   *
   * @return $this
   */
  public function setUnpublished();

  /**
   * Gets the To user id.
   * 
   * @return int
   *  The user id. 
   */
  public function getUserToId();

  /**
   * Sets the To user id.
   * 
   * @param int $uid 
   *  To user id. 
   * 
   * @return $this 
   */
  public function setUserToId($uid);

   /**
   * Gets the To user object.
   *
   * @return UserInterface
   * The user object.
   */
  public function getUserTo();


  /**
   * Gets the Content. 
   * 
   * @return string
   *  Bits Entities Message content. 
   */
  public function getContent();

  /**
   * Sets the message`s content. 
   * 
   * @param string $content
   *  Message's content.
   * 
   * @return $this 
   */
  public function setContent($content);

  /**
   * Returns the Bits Entities Message read indicator.
   * 
   * @return bool
   */
  public function isRead();

  /**
   * Sets the read status of a Bits Entities Message. 
   * 
   * @param bool read
   *  TRUE to set this Bits Entities Message to read.
   * 
   * @return $this
   */
  public function setRead($read);



  

}
