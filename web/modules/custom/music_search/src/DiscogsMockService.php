<?php

namespace Drupal\music_search;

/**
 * Mock service for Discogs.
 */
class DiscogsMockService implements SearchServiceInterface {

  /**
   * {@inheritdoc}
   */
  public function search(string $type, string $term): array {
    // Mocked response.
    return [
      ['title' => "Mocked Discogs $type 1: $term"],
      ['title' => "Mocked Discogs $type 2: $term"],
    ];
  }
}
