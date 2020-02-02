<?php

namespace Drupal\media_entity_remote_image\Plugin\Field\FieldWidget;

use Drupal\link\Plugin\Field\FieldWidget\LinkWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;


/**
 * @FieldWidget(
 *   id = "remote_image_url_widget",
 *   label = @Translation("Remote Image Url"),
 *   description = @Translation("A plaintext field for a remote image url plus fields for metadata."),
 *   field_types = {
 *     "remote_image_url"
 *   }
 * )
 */
class RemoteImageUrlWidget extends LinkWidget {

  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    unset($element['title']);
    unset($element['attributes']);

    $element['uri']['#description'] = $this->t('This must be an external URL such as %url. <strong>Please note</strong> that this field does not yet validate/ensure that the entered URL is an image.', ['%url' => 'http://example.com']);

    $element['alt'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Alt text'),
//      '#placeholder' => $this->getSetting('placeholder_title'),
      '#default_value' => isset($items[$delta]->alt) ? $items[$delta]->alt : NULL,
      '#maxlength' => 255,
//      '#access' => $this->getFieldSetting('title') != DRUPAL_DISABLED,
      '#required' => (\Drupal::routeMatch()->getRouteName() === 'entity.field_config.media_field_edit_form') ? false : true,
      '#description' => 'Short description of the image used by screen readers and displayed when the image is not loaded. This is important for accessibility. A default value must be entered for this field until it is made non-required on the field settings form.'
    ];

    return $element;
  }

}
