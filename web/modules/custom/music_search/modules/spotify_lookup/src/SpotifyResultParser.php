<?php

namespace Drupal\spotify_lookup;

/**
 * Parses Spotify API results into a structured array.
 */
class SpotifyResultParser {

  /**
   * Parses Spotify API results.
   *
   * @param array $items
   *   The raw Spotify API items.
   * @param string $type
   *   The type of items (artist, album, track).
   *
   * @return array
   *   A structured array of results for display or further use.
   */
  public function parseResults(array $items, string $type): array {
    $formattedResults = [];
    $baseSpotifyUrl = 'https://open.spotify.com';

    foreach ($items as $item) {
      // Extract main details.
      $name = $item['name'] ?? 'Unknown';
      $image = $item['images'][0]['url'] ?? ''; // Use the first image, if available.
      $uri = $item['uri'] ?? ''; // Spotify URI.
      $id = explode(':', $uri)[2] ?? null;

      // Extract artist details if available.
      $artists = [];
      if (isset($item['artists'])) {
        foreach ($item['artists'] as $artist) {
          $artists[] = [
            'name' => $artist['name'] ?? 'Unknown',
            'url' => $artist['external_urls']['spotify'] ?? '#',
          ];
        }
      }

      // Add the parsed data to the results.
      $formattedResults[] = [
        'name' => $name,
        'image' => $image,
        'uri' => $uri,
        'type' => ucfirst($type),
        'artists' => $artists,
        'spotify_url' => $id ? $baseSpotifyUrl . '/' . $type . '/' . $id : null,
      ];
    }

    return $formattedResults;
  }
}
