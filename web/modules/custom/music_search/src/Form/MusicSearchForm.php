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
   * @var MusicSearchService
   */
  protected MusicSearchService $musicSearchService;

  /**
   * The search results markup.
   *
   * @var array
   */
  protected array $searchResultsMarkup = [];

  /**
   * Constructs a MusicSearchForm object.
   *
   * @param MusicSearchService $musicSearchService
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

    // If results exist, display them.
    // If results exist, display them.
    if (!empty($this->searchResultsMarkup)) {
      $resultMarkup = '';

      foreach ($this->searchResultsMarkup as $provider => $providerMarkup) {
        if (!empty($providerMarkup)) {
          $resultMarkup .= '<h3>' . ucfirst($provider) . '</h3>';
          $resultMarkup .= '<ul>' . implode('', $providerMarkup) . '</ul>';
        }
      }

      $form['search_results'] = [
        '#type' => 'markup',
        '#markup' => $resultMarkup,
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $providers = array_filter($form_state->getValue('providers'));
    $search_type = $form_state->getValue('search_type');
    $search_term = $form_state->getValue('search_term');

    // Perform the search and get ready-to-display markup.
    $this->searchResultsMarkup = $this->musicSearchService->search($providers, $search_type, $search_term);

    // Rebuild the form to display results.
    $form_state->setRebuild(TRUE);
  }
}
