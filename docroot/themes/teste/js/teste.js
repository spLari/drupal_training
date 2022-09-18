/**
 * @file
 * teste behaviors.
 */
(function (Drupal) {

  'use strict';

  Drupal.behaviors.teste = {
    attach: function (context, settings) {

      console.log('It works!');

    }
  };

} (Drupal));
