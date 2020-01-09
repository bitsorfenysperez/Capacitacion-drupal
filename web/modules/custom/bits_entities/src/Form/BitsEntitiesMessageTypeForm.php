<?php

namespace Drupal\bits_entities\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class BitsEntitiesMessageTypeForm.
 */
class BitsEntitiesMessageTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $bits_entities_message_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $bits_entities_message_type->label(),
      '#description' => $this->t("Label for the Bits Entities Message type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $bits_entities_message_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\bits_entities\Entity\BitsEntitiesMessageType::load',
      ],
      '#disabled' => !$bits_entities_message_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $bits_entities_message_type = $this->entity;
    $status = $bits_entities_message_type->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Bits Entities Message type.', [
          '%label' => $bits_entities_message_type->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Bits Entities Message type.', [
          '%label' => $bits_entities_message_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($bits_entities_message_type->toUrl('collection'));
  }

}
