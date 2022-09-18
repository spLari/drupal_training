<?php

/**
 * @file
 * Theme settings form for teste theme.
 */

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function teste_form_system_theme_settings_alter(&$form, &$form_state) {

  $form['teste'] = [
    '#type' => 'details',
    '#title' => t('teste'),
    '#open' => TRUE,
  ];

  $form['teste']['font_size'] = [
    '#type' => 'number',
    '#title' => t('Font size'),
    '#min' => 12,
    '#max' => 18,
    '#default_value' => theme_get_setting('font_size'),
  ];

}
