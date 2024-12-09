<?php

namespace Drupal\music_search;

use Drupal\spotify_lookup\SpotifyLookupService;
use Drupal\discogs_lookup\DiscogsLookupService;

class MusicSearchService {
protected $spotifyService;
protected $discogsService;

public function __construct(SpotifyLookupService $spotifyService, DiscogsLookupService $discogsService) {
$this->spotifyService = $spotifyService;
$this->discogsService = $discogsService;
}

public function search($query) {
$spotifyResults = $this->spotifyService->search($query);
$discogsResults = $this->discogsService->search($query);

return [
'spotify' => $spotifyResults,
'discogs' => $discogsResults,
];
}
}
