<?php

namespace Drupal\external\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ExternalAdminSettings.
 *
 * @package Drupal\external\Form
 */
class ExternalAdminSettings extends ConfigFormBase {

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $config;

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->config = $config_factory->getEditable('external.settings');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
    // Load the service required to construct this class.
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'external_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['external.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('external.settings');
    $form = [];

    $form['external_enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable External Module'),
      '#default_value' => $config->get('external_enabled'),
    ];
    $form['external_docs_enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Open PDFs in new tabs'),
      '#default_value' => $config->get('external_docs_enabled'),
    ];
    $form['external_disabled_patterns'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Pages to exclude'),
      '#default_value' => $config->get('external_disabled_patterns'),
      '#description' => $this->t("Enter one page per line as Drupal paths. The '*' character is a wildcard. Example paths are %blog for the blog page and %blog-wildcard for every personal blog. %front is the front page.", [
        '%blog' => 'blog',
        '%blog-wildcard' => 'blog/*',
        '%front' => '<front>',
      ]),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('external.settings');
    $config->set('external_enabled', $form_state->getValue('external_enabled'));
    $config->set('external_docs_enabled', $form_state->getValue('external_docs_enabled'));
    $config->set('external_disabled_patterns', $form_state->getValue('external_disabled_patterns'));
    $config->save();

    parent::submitForm($form, $form_state);
  }

}
