<?php

namespace Osmuhin\HtmlMeta\Distributors;

use InvalidArgumentException;
use Osmuhin\HtmlMeta\Contracts\Distributor;
use Osmuhin\HtmlMeta\Dto\Meta;
use Osmuhin\HtmlMeta\Element;

abstract class AbstractDistributor implements Distributor
{
	protected Meta $meta;

	/** @var \Osmuhin\HtmlMeta\Distributors\AbstractDistributor[] */
	private array $subDistributors = [];

	public static function init(): self
	{
		return new static();
	}

	public function setMeta(Meta $meta): self
	{
		$this->meta = $meta;

		foreach ($this->subDistributors as $subDistributor) {
			$subDistributor->setMeta($meta);
		}

		return $this;
	}

	public function getMeta(): Meta
	{
		return $this->meta;
	}

	public function useSubDistributors(...$args): self
	{
		$distributors = $args;

		foreach ($distributors as $distributor) {
			$this->setSubDistributor($distributor);
		}

		return $this;
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public function setSubDistributor(Distributor|string $distributor, ?string $key = null): self
	{
		$distributor = is_string($distributor) ? new $distributor() : $distributor;

		if (!($distributor instanceof Distributor)) {
			$class = $distributor::class;
			throw new InvalidArgumentException("{$class} must implements \Osmuhin\HtmlMeta\Contracts\Distributor interface");
		}

		$key ??= $distributor::class;

		$this->subDistributors[$key] = $distributor;

		return $this;
	}

	public function getSubDistributor(string $key): Distributor|null
	{
		return @$this->subDistributors[$key];
	}

	protected static function assignAccordingToTheMap(array $map, object $object, string $name, string $content): bool
	{
		if (isset($map[$name])) {
			$object->{$map[$name]} ??= $content;

			return true;
		}

		return false;
	}

	protected function pollSubDistributors(Element $el): bool
	{
		foreach ($this->subDistributors as $subDistributor) {
			if ($subDistributor->canHandle($el)) {
				$subDistributor->pollSubDistributors($el) || $subDistributor->handle($el);

				return true;
			}
		}

		return false;
	}
}
