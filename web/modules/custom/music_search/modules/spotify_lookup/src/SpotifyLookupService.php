<?php

namespace Drupal\spotify_lookup;

use Drupal\music_search\SearchServiceInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Service to interact with Spotify's API.
 */
class SpotifyLookupService implements SearchServiceInterface {

  /**
   * The HTTP client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected ClientInterface $httpClient;

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected ConfigFactoryInterface $configFactory;

  /**
   * Constructs a SpotifyLookupService object.
   *
   * @param \GuzzleHttp\ClientInterface $httpClient
   *   The HTTP client.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The configuration factory.
   */
  public function __construct(ClientInterface $httpClient, ConfigFactoryInterface $configFactory) {
    $this->httpClient = $httpClient;
    $this->configFactory = $configFactory;
  }

  /**
   * {@inheritdoc}
   */
  public function search(string $type, string $term): array {
    // Map 'song' to 'track'.
    $spotifyType = $type === 'song' ? 'track' : $type;

    // Get the stored API token.
    $config = $this->configFactory->get('spotify_lookup.settings');
    $accessToken = $config->get('api_token');

    if (!$accessToken) {
      \Drupal::logger('spotify_lookup')->error('No API token available for Spotify.');
      return [];
    }

    // Spotify API URL.
    $url = 'https://api.spotify.com/v1/search';

    try {
      // Send the request to Spotify API.
      $response = $this->httpClient->get($url, [
        'query' => [
          'q' => $term,
          'type' => $spotifyType,
        ],
        'headers' => [
          'Authorization' => 'Bearer ' . $accessToken,
        ],
      ]);

      // Decode the JSON response.
      $data = json_decode($response->getBody(), TRUE);

      // Return the relevant part of the response.
      return $data["{$spotifyType}s"]['items'] ?? [];
    }
    catch (GuzzleException $e) {
      \Drupal::logger('spotify_lookup')->error('Spotify API error: @message', ['@message' => $e->getMessage()]);
      return [];
    }
  }
}
