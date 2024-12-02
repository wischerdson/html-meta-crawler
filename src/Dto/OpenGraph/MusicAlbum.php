<?php

namespace Osmuhin\HtmlMeta\Dto\OpenGraph;

use Osmuhin\HtmlMeta\Contracts\Dto;

class MusicAlbum implements Dto
{
	public ?string $song = null;

	public ?string $songDisc = null;

	public ?string $songTrack = null;

	public ?string $releaseDate = null;

	public ?string $musician = null;

	public function toArray(): array
	{
		return [
			'song' => $this->song,
			'songDisc' => $this->songDisc,
			'songTrack' => $this->songTrack,
			'releaseDate' => $this->releaseDate,
			'musician' => $this->musician,
		];
	}
}
