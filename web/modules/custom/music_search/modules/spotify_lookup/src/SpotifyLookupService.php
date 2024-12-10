<?php
namespace Drupal\spotify_lookup;

use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SpotifyLookupService {

  protected $configFactory;
  protected $httpClient;
  private $client;
  private $apiKey;

  public function __construct(ConfigFactoryInterface $config_factory, Client $client) {
    $this->configFactory = $config_factory;
    $this->httpClient = $client;
    // Load the API key from configuration.
    $config = $this->configFactory->get('spotify_lookup.settings');
    $this->apiKey = $config->get('api_key');
  }

  // Function to search for a track on Spotify
  public function searchTrack($track_name) {
    // Spotify search API URL
    $url = 'https://api.spotify.com/v1/search';

    // Send request to Spotify API
    try {
      $response = $this->httpClient->get($url, [
        'query' => [
          'q' => $track_name,
          'type' => 'track',
        ],
        'headers' => [
          'Authorization' => 'Bearer ' . $this->apiKey,
        ],
      ]);

      // Decode the JSON response
      $data = json_decode($response->getBody(), TRUE);
      return $data['tracks']['items']; // Return list of tracks
    }
    catch (\Exception $e) {
      // Handle any errors (e.g., invalid API key or request issue)
      \Drupal::logger('music_search')->error('Error fetching Spotify data: ' . $e->getMessage());
      return [];
    } catch (GuzzleException $e) {
      return [];
    }
  }

  public function search($query) {
    // TODO: Implement the search function
  }
}


