<?php

namespace Drupal\music_search;

/**
 * Mock service for Spotify.
 */
class SpotifyMockService implements SearchServiceInterface {

  /**
   * {@inheritdoc}
   */
  public function search(string $type, string $term): array {
    // Mocked response.
    return [
      ['title' => "Mocked Spotify $type 1: $term"],
      ['title' => "Mocked Spotify $type 2: $term"],
    ];
  }
}
