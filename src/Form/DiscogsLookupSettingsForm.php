<?php

namespace Drupal\discogs_lookup\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configures Discogs Lookup settings.
 */
class DiscogsLookupSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'discogs_lookup_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['discogs_lookup.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('discogs_lookup.settings');

    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Discogs API Key'),
      '#default_value' => $config->get('api_key'),
      '#required' => TRUE,
      '#description' => $this->t('Enter your Discogs API key'),
    ];

    $form['api_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Discogs API Secret'),
      '#default_value' => $config->get('api_secret'),
      '#required' => TRUE,
      '#description' => $this->t('Enter your Discogs API secret'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('discogs_lookup.settings')
      ->set('api_key', $form_state->getValue('api_key'))
      ->set('api_secret', $form_state->getValue('api_secret'))
      ->save();

    parent::submitForm($form, $form_state);
  }
} 