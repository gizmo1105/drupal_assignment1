<?php
namespace Drupal\spotify_lookup;

use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\Client;

/**
 * Service to interact with the Spotify API.
 */
class SpotifyLookupService {

  protected ConfigFactoryInterface $configFactory;
  protected Client $httpClient;
  private mixed $apiKey;

  /**
   * Constructs the SpotifyLookupService.
   */
  public function __construct(ConfigFactoryInterface $config_factory, Client $client) {
    $this->configFactory = $config_factory;
    $this->httpClient = $client;

    // Load the API key from configuration.
    $config = $this->configFactory->get('spotify_lookup.settings');
    $this->apiKey = $config->get('api_key');

    if (empty($this->apiKey)) {
      \Drupal::logger('spotify_lookup')->error('Spotify API key is missing. Please configure it in the settings.');
    }
  }

  /**
   * Performs a search on Spotify.
   *
   * @param string $query
   *   The search query.
   * @param string $type
   *   The type of content to search for. Possible values: 'track', 'album', 'artist'.
   *
   * @return array
   *   The search results or an empty array in case of an error.
   */
  public function search(string $query, string $type = 'track'): array {
    $url = 'https://api.spotify.com/v1/search';

    try {
      $response = $this->httpClient->get($url, [
        'query' => [
          'q' => $query,
          'type' => $type,
        ],
        'headers' => [
          'Authorization' => 'Bearer ' . $this->apiKey,
        ],
      ]);

      // Decode the JSON response and return the relevant data.
      $data = json_decode($response->getBody(), TRUE);
      return $data[$type . 's']['items'] ?? [];
    }
    catch (\Exception $e) {
      \Drupal::logger('spotify_lookup')->error('Error fetching Spotify data: ' . $e->getMessage());
      return [];
    }
  }
}



