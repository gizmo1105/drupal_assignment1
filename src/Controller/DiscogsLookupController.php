<?php

namespace Drupal\discogs_lookup\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\discogs_lookup\DiscogsApiService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller for Discogs lookup functionality.
 */
class DiscogsLookupController extends ControllerBase {

  /**
   * The Discogs API service.
   *
   * @var \Drupal\discogs_lookup\DiscogsApiService
   */
  protected $discogsApi;

  /**
   * Constructs a DiscogsLookupController object.
   *
   * @param \Drupal\discogs_lookup\DiscogsApiService $discogs_api
   *   The Discogs API service.
   */
  public function __construct(DiscogsApiService $discogs_api) {
    $this->discogsApi = $discogs_api;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('discogs_lookup.api')
    );
  }

  /**
   * Performs a search using the Discogs API.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   *
   * @return array
   *   A render array.
   */
  public function search(Request $request) {
    $query = $request->query->get('q');
    $results = [];

    if ($query) {
      $results = $this->discogsApi->searchReleases($query);
    }

    return [
      '#theme' => 'discogs_lookup_results',
      '#results' => $results,
      '#query' => $query,
    ];
  }
} 