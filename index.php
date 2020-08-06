<?php
/**
 * Plugin name: Encrypted ACF Fields
 * Plugin URI: https://github.com/ozramos/private-acf-fields
 * Description: Adds a field setting to Advanced Custom Fields so that they are encrypted on save
 * Author: Oz Ramos
 * Author URI: https://ozramos.com
 * License: Apache 2.0
 * License URI: http://www.apache.org/licenses/LICENSE-2.0
 */
define('ENCRYPTED_ACF_FIELDS_FILE', __FILE__);

/**
 * Add the setting
 */
add_action('acf/render_field_settings', function ($field) {
  acf_render_field_setting($field, [
    'label' => 'Admin only?',
    'instructions' => 'If checked, hides this field from edit screen and makes it editable only by admins',
    'name' => 'admin_only',
    'type' => 'true_false',
    'ui' => 1
  ]);
});

/**
 * Prevent field from showing up
 */
add_action('acf/prepare_field', function ($field) {
  if (empty($field['admin_only'])) {
    return $field;
  }

  // Hide if not admin
  if (!current_user_can('administrator')) {
    return false;
  }

  return $field;
});