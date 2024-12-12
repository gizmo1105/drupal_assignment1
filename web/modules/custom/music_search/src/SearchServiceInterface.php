<?php

namespace Drupal\music_search;

/**
 * Interface for specific music search services.
 */
interface SearchServiceInterface {

  /**
   * Performs a search query.
   *
   * @param string $type
   *   The type of search (e.g., "artist", "album", "song").
   * @param string $term
   *   The search term.
   *
   * @return array
   *   An array of search results.
   */
  public function search(string $type, string $term): array;

  public function getDetails(array $params): array;
}
