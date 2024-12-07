<?php

namespace Osmuhin\HtmlMeta;

use Osmuhin\HtmlMeta\Distributors\AbstractDistributor;

class MainDistributor extends AbstractDistributor
{
	public function __construct()
	{
		$this->useSubDistributors(
			\Osmuhin\HtmlMeta\Distributors\HtmlDistributor::init(),
			\Osmuhin\HtmlMeta\Distributors\TitleDistributor::init(),
			\Osmuhin\HtmlMeta\Distributors\MetaDistributor::init()->useSubDistributors(
				\Osmuhin\HtmlMeta\Distributors\HttpEquivDistributor::init(),
				\Osmuhin\HtmlMeta\Distributors\TwitterDistributor::init(),
				\Osmuhin\HtmlMeta\Distributors\OpenGraphDistributor::init()
			),
			\Osmuhin\HtmlMeta\Distributors\LinkDistributor::init()->useSubDistributors(
				\Osmuhin\HtmlMeta\Distributors\FaviconDistributor::init()
			)
		);
	}

	public function canHandle(Element $element): bool
	{
		return true;
	}

	public function handle(Element $element): void
	{
		$this->pollSubDistributors($element);
	}
}
