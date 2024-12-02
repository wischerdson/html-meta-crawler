<?php

namespace Osmuhin\HtmlMeta\Dto\OpenGraph;

use Osmuhin\HtmlMeta\Contracts\Dto;

class Book implements Dto
{
	public ?string $author = null;

	public ?string $isbn = null;

	public ?string $release_date = null;

	public ?string $tag = null;

	public function toArray(): array
	{
		return [
			'author' => $this->author,
			'isbn' => $this->isbn,
			'release_date' => $this->release_date,
			'tag' => $this->tag
		];
	}
}
