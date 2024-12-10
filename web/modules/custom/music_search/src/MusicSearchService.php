<?php

namespace Drupal\music_search;

/**
 * Generic music search service that delegates to specific services.
 */
class MusicSearchService {

  /**
   * The array of specific search services.
   *
   * @var \Drupal\music_search\SearchServiceInterface[]
   */
  protected array $searchServices;

  /**
   * Constructs a MusicSearchService object.
   *
   * @param \Drupal\music_search\SearchServiceInterface[] $searchServices
   *   An array of specific search service instances.
   */
  public function __construct(array $searchServices) {
    $this->searchServices = $searchServices;
  }

  /**
   * Performs a search across all selected services.
   *
   * @param array $providers
   *   The selected providers (e.g., ["spotify", "discogs"]).
   * @param string $type
   *   The type of search (e.g., "artist", "album", "song").
   * @param string $term
   *   The search term.
   *
   * @return array
   *   A combined array of results from all providers.
   */
  public function search(array $providers, string $type, string $term): array {
    $results = [];

    foreach ($providers as $provider) {
      if (isset($this->searchServices[$provider])) {
        $results[$provider] = $this->searchServices[$provider]->search($type, $term);
      }
    }

    return $results;
  }
}
