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
   * The Spotify result parser.
   *
   * @var \Drupal\spotify_lookup\SpotifyResultParser
   */
  protected SpotifyResultParser $resultParser;

  /**
   * Constructs a SpotifyLookupService object.
   *
   * @param \GuzzleHttp\ClientInterface $httpClient
   *   The HTTP client.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The configuration factory.
   * @param \Drupal\spotify_lookup\SpotifyResultParser $resultParser
   *   The result parser service.
   */
  public function __construct(ClientInterface $httpClient, ConfigFactoryInterface $configFactory, SpotifyResultParser $resultParser) {
    $this->httpClient = $httpClient;
    $this->configFactory = $configFactory;
    $this->resultParser = $resultParser;
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

      // Extract the items for the specified type.
      $items = $data["{$spotifyType}s"]['items'] ?? [];

      // Use the parser to generate markup.
      return $this->resultParser->parseResults($items, $spotifyType);
    }
    catch (GuzzleException $e) {
      \Drupal::logger('spotify_lookup')->error('Spotify API error: @message', ['@message' => $e->getMessage()]);

      return [];
    }
  }
}

