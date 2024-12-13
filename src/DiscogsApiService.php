<?php

namespace Drupal\discogs_lookup;

use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\ClientInterface;
use Drupal\Component\Serialization\Json;

/**
 * Service for interacting with the Discogs API.
 */
class DiscogsApiService {

  /**
   * The HTTP client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a DiscogsApiService object.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ClientInterface $http_client, ConfigFactoryInterface $config_factory) {
    $this->httpClient = $http_client;
    $this->configFactory = $config_factory;
  }

  /**
   * Search for releases on Discogs.
   *
   * @param string $query
   *   The search query.
   *
   * @return array
   *   The search results.
   */
  public function searchReleases($query) {
    $config = $this->configFactory->get('discogs_lookup.settings');
    $api_key = $config->get('api_key');
    $api_secret = $config->get('api_secret');

    try {
      $response = $this->httpClient->request('GET', 'https://api.discogs.com/database/search', [
        'query' => [
          'q' => $query,
          'key' => $api_key,
          'secret' => $api_secret,
          'type' => 'release',
        ],
        'headers' => [
          'User-Agent' => 'DiscogsLookupDrupal/1.0',
        ],
      ]);

      $data = Json::decode($response->getBody());
      return $data['results'] ?? [];
    }
    catch (\Exception $e) {
      \Drupal::logger('discogs_lookup')->error('Error searching Discogs: @message', ['@message' => $e->getMessage()]);
      return [];
    }
  }
} 