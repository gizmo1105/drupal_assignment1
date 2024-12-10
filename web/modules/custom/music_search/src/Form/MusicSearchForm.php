<?php

namespace Drupal\music_search\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\music_search\MusicSearchService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides the Music Search Form.
 */
class MusicSearchForm extends FormBase {

  /**
   * The music search service.
   *
   * @var \Drupal\music_search\MusicSearchService
   */
  protected MusicSearchService $musicSearchService;

  /**
   * Constructs a MusicSearchForm object.
   *
   * @param \Drupal\music_search\MusicSearchService $musicSearchService
   *   The music search service.
   */
  public function __construct(MusicSearchService $musicSearchService) {
    $this->musicSearchService = $musicSearchService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): static {
    return new static(
      $container->get('music_search.service')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'music_search_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['providers'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Search Providers'),
      '#options' => [
        'spotify' => $this->t('Spotify'),
        'discogs' => $this->t('Discogs'),
      ],
      '#required' => TRUE,
    ];

    $form['search_type'] = [
      '#type' => 'radios',
      '#title' => $this->t('Search Type'),
      '#options' => [
        'artist' => $this->t('Artist'),
        'album' => $this->t('Album'),
        'song' => $this->t('Song'),
      ],
      '#default_value' => 'artist',
      '#required' => TRUE,
    ];

    $form['search_term'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search Term'),
      '#required' => TRUE,
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Search'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $providers = array_filter($form_state->getValue('providers'));
    $search_type = $form_state->getValue('search_type');
    $search_term = $form_state->getValue('search_term');

    $results = $this->musicSearchService->search($providers, $search_type, $search_term);

    foreach ($results as $provider => $provider_results) {
      $this->messenger()->addMessage($this->t('Results from @provider: @count results.', [
        '@provider' => ucfirst($provider),
        '@count' => count($provider_results),
      ]));
    }
  }
}
