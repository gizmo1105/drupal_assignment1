<?php

namespace Drupal\music_search\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


use Drupal\spotify_lookup\SpotifyLookupService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MusicSearchForm extends FormBase {

  protected SpotifyLookupService $spotifyService;

  // Inject Spotify service
  public function __construct(SpotifyLookupService $spotify_lookup_service) {
    $this->spotifyService = $spotify_lookup_service;
  }

  public static function create(ContainerInterface $container): MusicSearchForm|static
  {
    return new static(
      $container->get('music_search.spotify_lookup_service')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string
  {
    return 'music_search_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array
  {
    $form['track_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Track Name'),
      '#description' => $this->t('Enter the name of the track you want to search for.'),
      '#required' => TRUE,
    ];

    $form['search_results'] = [
      '#markup' => $this->t('Search results will appear here.'),
    ];

    $form['#submit'][] = '::submitForm';
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void
  {
    $track_name = $form_state->getValue('track_name');

    // Use SpotifyLookupService to search for the track
    $results = $this->spotifyService->searchTrack($track_name);

    // Prepare the results for display
    $result_markup = '<ul>';
    foreach ($results as $track) {
      $result_markup .= '<li>' . $track['name'] . ' by ' . $track['artists'][0]['name'] . '</li>';
    }
    $result_markup .= '</ul>';

    // Display the results in the form
    $form['search_results']['#markup'] = $result_markup;
  }
}

