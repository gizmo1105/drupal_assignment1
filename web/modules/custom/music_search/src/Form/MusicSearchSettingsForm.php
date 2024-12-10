<?php
namespace Drupal\music_search\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class MusicSearchSettingsForm extends ConfigFormBase {
  public function getFormId(): string
  {
    return 'music_search_settings';
  }
    protected function getEditableConfigNames(): array
    {
      return ['music_search.settings'];
    }

  public function buildForm(array $form, FormStateInterface $form_state): array
  {
    $config = $this->config('music_search.settings');

    $form['spotify_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Spotify API Key'),
      '#default_value' => $config->get('spotify_api_key'),
    ];

    $form['discogs_api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Discogs API Key'),
      '#default_value' => $config->get('discogs_api_key'),
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state): void
  {
    $this->config('music_search.settings')
      ->set('spotify_api_key', $form_state->getValue('spotify_api_key'))
      ->set('discogs_api_key', $form_state->getValue('discogs_api_key'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}

