<?php

declare(strict_types=1);

namespace Sandbox\Carve;

use MarkupCarve\Carve\Attrs;
use MarkupCarve\Carve\Extension\Claim;
use MarkupCarve\Carve\Extension\ExtensionDefinition;
use MarkupCarve\Carve\Extension\ExtensionProvider;
use MarkupCarve\Carve\Extension\RenderHost;
use MarkupCarve\Carve\Node;

/**
 * Host extension that renders a `::: tree` marked `{.collapsible}` as nested `<details>`.
 *
 * A tree without the class is left to core (a plain `<div class="tree">` around a list).
 */
class TreeExtension implements ExtensionProvider {

	public const NAME = 'sandbox.tree';

	public const KIND = 'tree';

	public const CLASS_COLLAPSIBLE = 'collapsible';

	public const CLASS_COLLAPSED = 'collapsed';

	/**
	 * @return array<\MarkupCarve\Carve\Extension\ExtensionDefinition>
	 */
	public function definitions(): array {
		$render = fn (Node $node, RenderHost $host): string => $this->render($node, $host);

		return [new ExtensionDefinition(
			static::NAME,
			'1',
			['body'],
			matcher: ['form' => 'div', 'name' => static::KIND],
			transform: function (Claim $claim): ?Node {
				$attrs = $claim->node->f['attrs'] ?? null;
				$classes = $attrs instanceof Attrs ? $attrs->classes : [];
				if (!in_array(static::CLASS_COLLAPSIBLE, $classes, true) || $this->findList($claim->node->children ?? []) === null) {
					return null;
				}

				$node = new Node('block_extension', []);
				$node->f = [
					'name' => static::NAME,
					'version' => '1',
					'slots' => ['body' => $claim->node->children ?? []],
					'props' => ['open' => !in_array(static::CLASS_COLLAPSED, $classes, true)],
					'fallback' => [$claim->copyNode()],
				];

				return $node;
			},
			renderer: $render,
			buildTimeRenderer: $render,
		)];
	}

	/**
	 * @param \MarkupCarve\Carve\Node $node
	 * @param \MarkupCarve\Carve\Extension\RenderHost $host
	 * @return string
	 */
	protected function render(Node $node, RenderHost $host): string {
		$list = $this->findList($node->f['slots']['body'] ?? []);
		if ($list === null) {
			return '';
		}
		// A static render (print, PDF) never receives a click, so every branch stays open there.
		$open = ($node->f['props']['open'] ?? true) || $host->mode === 'static';

		return '<div' . $this->attributes($node->f['attrs'] ?? null) . ">\n"
			. $this->renderList($list, $host, $open, 1)
			. '</div>';
	}

	/**
	 * @param mixed $attrs
	 * @return string
	 */
	protected function attributes(mixed $attrs): string {
		if (!$attrs instanceof Attrs) {
			return '';
		}
		$out = '';
		if ($attrs->id !== null) {
			$out .= ' id="' . RenderHost::escapeAttribute($attrs->id) . '"';
		}
		$classes = array_merge([static::KIND], array_diff($attrs->classes, [static::KIND]));
		$out .= ' class="' . RenderHost::escapeAttribute(implode(' ', $classes)) . '"';
		foreach ($attrs->pairs as [$key, $value]) {
			if (preg_match('/^data-[a-z0-9-]+$/', $key) === 1) {
				$out .= ' ' . $key . '="' . RenderHost::escapeAttribute($value) . '"';
			}
		}

		return $out;
	}

	/**
	 * @param array<\MarkupCarve\Carve\Node> $children
	 * @return \MarkupCarve\Carve\Node|null
	 */
	protected function findList(array $children): ?Node {
		foreach ($children as $child) {
			if ($child->type === 'list') {
				return $child;
			}
		}

		return null;
	}

	/**
	 * @param \MarkupCarve\Carve\Node $list
	 * @param \MarkupCarve\Carve\Extension\RenderHost $host
	 * @param bool $open
	 * @param int $depth
	 * @return string
	 */
	protected function renderList(Node $list, RenderHost $host, bool $open, int $depth): string {
		$pad = str_repeat('  ', $depth);
		$html = $pad . "<ul>\n";
		foreach ($list->children ?? [] as $item) {
			if ($item->type === 'list_item') {
				$html .= $this->renderItem($item, $host, $open, $depth + 1);
			}
		}

		return $html . $pad . "</ul>\n";
	}

	/**
	 * @param \MarkupCarve\Carve\Node $item
	 * @param \MarkupCarve\Carve\Extension\RenderHost $host
	 * @param bool $open
	 * @param int $depth
	 * @return string
	 */
	protected function renderItem(Node $item, RenderHost $host, bool $open, int $depth): string {
		$pad = str_repeat('  ', $depth);
		$label = '';
		foreach ($item->children ?? [] as $child) {
			if ($child->type === 'paragraph') {
				$label = ($host->inlines)($child->children ?? []);

				break;
			}
		}
		$sublist = $this->findList($item->children ?? []);
		if ($sublist === null) {
			return $pad . '<li>' . $label . "</li>\n";
		}

		return $pad . '<li><details' . ($open ? ' open' : '') . '><summary>' . $label . "</summary>\n"
			. $this->renderList($sublist, $host, $open, $depth + 1)
			. $pad . "</details></li>\n";
	}

}
