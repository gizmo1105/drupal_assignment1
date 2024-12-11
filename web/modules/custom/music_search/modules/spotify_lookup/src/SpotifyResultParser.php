<?php

namespace Drupal\spotify_lookup;

/**
 * Parses Spotify API results into markup.
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
   *   An array of markup strings for display.
   */
  public function parseResults(array $items, string $type): array {
    $formattedResults = [];
    $baseSpotifyUrl = 'https://open.spotify.com';

    foreach ($items as $item) {
      // Extract main details.
      $name = htmlspecialchars($item['name'] ?? 'Unknown', ENT_QUOTES);
      $image = $item['images'][0]['url'] ?? ''; // Use the first image, if available.
      $uri = $item['uri'] ?? ''; // Spotify URI.
      $id = explode(':', $uri)[2] ?? null;
      $typeFormatted = ucfirst($type);

      // Handle artists for albums or tracks.
      $artistInfo = '';
      if (isset($item['artists'])) {
        $artistLinks = [];
        foreach ($item['artists'] as $artist) {
          $artistName = htmlspecialchars($artist['name'], ENT_QUOTES);
          $artistUrl = $artist['external_urls']['spotify'] ?? '#';
          $artistLinks[] = '<a href="' . htmlspecialchars($artistUrl, ENT_QUOTES) . '" target="_blank">' . $artistName . '</a>';
        }
        $artistInfo = ' by ' . implode(', ', $artistLinks);
      }

      // Start constructing the markup.
      $markup = '<li>';
      if ($image) {
        $markup .= '<img src="' . htmlspecialchars($image, ENT_QUOTES) . '" alt="' . $name . '" style="width:50px;height:50px;"> ';
      }
      $markup .= '<strong>' . $name . '</strong> (' . $typeFormatted . ')';

      // Add artists and Spotify link.
      $markup .= $artistInfo;
      if ($id) {
        $markup .= ' - <a href="' . $baseSpotifyUrl . '/' . $type . '/' . $id . '" target="_blank">View on Spotify</a>';
      }
      $markup .= '</li>';

      // Add to results.
      $formattedResults[] = $markup;
    }

    return $formattedResults;
  }
}


