<?php

namespace Drupal\media_entity_tumblr\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\media_entity_tumblr\TumblrMarkup;
use Drupal\media_entity_tumblr\Plugin\MediaEntity\Type\Tumblr;

/**
 * Plugin implementation of the 'tumblr_embed' formatter.
 *
 * @FieldFormatter(
 *   id = "tumblr_embed",
 *   label = @Translation("Tumblr embed"),
 *   field_types = {
 *     "link", "string", "string_long"
 *   }
 * )
 */
class TumblrEmbedFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    /** @var \Drupal\media_entity\MediaInterface $media_entity */
    $media_entity = $items->getEntity();

    $element = [];
    if (($type = $media_entity->getType()) && $type instanceof Tumblr) {
      foreach ($items as $delta => $item) {
        $element[$delta] = [
          '#markup' => TumblrMarkup::create($type->getField($media_entity, 'html')),
        ];
      }
    }

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    return $field_definition->getTargetEntityTypeId() === 'media';
  }

}
