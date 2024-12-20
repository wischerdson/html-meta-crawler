<?php

namespace Tests\Distributors;

use Osmuhin\HtmlMeta\Distributors\HtmlDistributor;
use Osmuhin\HtmlMeta\Dto\Meta;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Traits\ElementCreator;

final class HtmlDistributorTest extends TestCase
{
	use ElementCreator;

	private Meta $meta;

	private HtmlDistributor $distributor;

	protected function setUp(): void
	{
		$this->meta = new Meta();
		$this->distributor = new HtmlDistributor();
		$this->distributor->setMeta($this->meta);
	}

	#[Test]
	#[TestDox('Test "canHandle" method of the distributor')]
	public function test_can_handle_method()
	{
		$element = self::makeElement('head');
		self::assertFalse($this->distributor->canHandle($element));

		$element = self::makeElement('html');
		self::assertTrue($this->distributor->canHandle($element));
	}

	#[Test]
	public function test_handle_method()
	{
		$element = self::makeElement('html', ['lang' => 'ru_RU', 'dir' => 'rtl', 'class' => 'dark']);

		$this->distributor->handle($element);

		self::assertSame('ru_RU', $this->meta->lang);
		self::assertSame('rtl', $this->meta->dir);

		self::assertCount(3, $this->meta->htmlAttributes);

		self::assertArrayHasKey('lang', $this->meta->htmlAttributes);
		self::assertArrayHasKey('dir', $this->meta->htmlAttributes);
		self::assertArrayHasKey('class', $this->meta->htmlAttributes);

		self::assertSame('ru_RU', $this->meta->htmlAttributes['lang']);
		self::assertSame('rtl', $this->meta->htmlAttributes['dir']);
		self::assertSame('dark', $this->meta->htmlAttributes['class']);
	}
}
