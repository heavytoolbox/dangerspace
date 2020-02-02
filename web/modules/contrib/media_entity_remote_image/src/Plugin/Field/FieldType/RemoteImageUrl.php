<?php

namespace Drupal\media_entity_remote_image\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\link\Plugin\Field\FieldType\LinkItem;


/**
* Plugin implementation of the 'remote_image_url' field type.
*
* @FieldType(
*   id = "remote_image_url",
*   label = @Translation("Remote Image URL"),
*   description = @Translation("This field is used to the URL of a remote image and its associated metadata."),
*   category = @Translation("General"),
*   default_widget = "remote_image_url_widget",
*   default_formatter = "remote_image_url_formatter"
* )
*/
class RemoteImageUrl extends LinkItem {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = parent::propertyDefinitions($field_definition);

    $properties['alt'] = DataDefinition::create('string')
      ->setLabel(t('Img alt text'));

    unset($properties['title']);
    unset($properties['options']);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = parent::schema($field_definition);

    unset($schema['columns']['title']);
    unset($schema['columns']['options']);

    $schema['columns']['alt'] = [
      'description' => 'The URI to be used for the img SRC.',
      'type' => 'varchar',
      'length' => 255,
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    /**
     * @todo: Set this value without lazily rendering a hidden settings form.
     */
    $element['link_type'] = [
      '#type' => 'radios',
      '#title' => t('Allowed link type'),
      '#attributes' => [
        'hidden' => [
          'hidden'
        ]
      ],
      '#default_value' => static::LINK_EXTERNAL,
      '#options' => [
        static::LINK_EXTERNAL => t('External links only'),
      ],
    ];

    return $element;
  }
}
