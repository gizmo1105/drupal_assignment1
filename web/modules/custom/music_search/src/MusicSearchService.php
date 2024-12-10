<?php

namespace Drupal\music_search;

use Drupal\spotify_lookup\SpotifyLookupService;

class MusicSearchService {
protected $spotifyService;


public function __construct(SpotifyLookupService $spotifyService, DiscogsLookupService $discogsService) {
$this->spotifyService = $spotifyService;
}

public function search($query) {
$spotifyResults = $this->spotifyService->search($query);

return [
'spotify' => $spotifyResults,
];
}
}
