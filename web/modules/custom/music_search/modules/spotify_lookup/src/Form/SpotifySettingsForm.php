<?php

namespace Drupal\spotify_lookup\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a settings form for Spotify Lookup.
 */
class SpotifySettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['spotify_lookup.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'spotify_lookup_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('spotify_lookup.settings');

    $form['client_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Spotify Client ID'),
      '#default_value' => $config->get('client_id'),
      '#required' => TRUE,
    ];

    $form['client_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Spotify Client Secret'),
      '#default_value' => $config->get('client_secret'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('spotify_lookup.settings')
      ->set('client_id', $form_state->getValue('client_id'))
      ->set('client_secret', $form_state->getValue('client_secret'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}