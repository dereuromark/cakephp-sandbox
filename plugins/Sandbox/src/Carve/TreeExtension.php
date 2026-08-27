<?php

declare(strict_types=1);

namespace Sandbox\Carve;

use MarkupCarve\Carve\CarveConverter;
use MarkupCarve\Carve\Event\RenderEvent;
use MarkupCarve\Carve\Extension\ExtensionInterface;
use MarkupCarve\Carve\Node\Block\Div;
use MarkupCarve\Carve\Node\Block\ListBlock;
use MarkupCarve\Carve\Node\Block\ListItem;
use MarkupCarve\Carve\Node\Block\Paragraph;
use MarkupCarve\Carve\Node\Node;
use MarkupCarve\Carve\Renderer\HtmlRenderer;

/**
 * Renders a `::: tree` container marked `{.collapsible}` as nested
 * `<details>`/`<summary>` disclosures instead of a plain nested `<ul>`.
 *
 * This lives in the sandbox rather than in carve-php on purpose: it is a
 * working prototype of the proposed Tier-2 Tree extension, and it demonstrates
 * that the host application can add the behavior without any engine change.
 *
 * A plain `::: tree` is left alone. The core renderer already emits
 *
 *     <div class="tree"><ul>...</ul></div>
 *
 * which is a correct, semantic, linkable tree; the sandbox stylesheet draws the
 * connectors. Only the collapsible variant needs different HTML, because a
 * disclosure widget cannot be produced from a `<ul>` by CSS alone.
 *
 * Input:
 *
 *     {.collapsible}
 *     ::: tree
 *     - src/
 *       - parser/
 *         - blocks.crv
 *     :::
 *
 * Output:
 *
 *     <div class="tree collapsible">
 *       <ul>
 *         <li><details open><summary>src/</summary>
 *           <ul>...</ul>
 *         </details></li>
 *       </ul>
 *     </div>
 *
 * Branches start expanded so the content stays visible to in-page search and to
 * a reader who never clicks. `{.collapsible .collapsed}` starts them closed.
 * Leaves stay plain `<li>` elements - a disclosure with nothing to disclose is
 * noise for a screen reader.
 */
class TreeExtension implements ExtensionInterface {

	/**
	 * Class that marks a container as a tree.
	 *
	 * @var string
	 */
	public const KIND = 'tree';

	/**
	 * Class that opts a tree into the disclosure rendering.
	 *
	 * @var string
	 */
	public const CLASS_COLLAPSIBLE = 'collapsible';

	/**
	 * Class that makes collapsible branches start closed.
	 *
	 * @var string
	 */
	public const CLASS_COLLAPSED = 'collapsed';

	/**
	 * @param \MarkupCarve\Carve\CarveConverter $converter Converter to hook into.
	 * @return void
	 */
	public function register(CarveConverter $converter): void {
		$renderer = $converter->getRenderer();
		if (!$renderer instanceof HtmlRenderer) {
			return;
		}

		$converter->on('render.div', function (RenderEvent $event) use ($renderer): void {
			$node = $event->getNode();
			if (!$node instanceof Div) {
				return;
			}
			if (!$node->hasClass(static::KIND) || !$node->hasClass(static::CLASS_COLLAPSIBLE)) {
				return;
			}

			$list = $this->findList($node);
			if ($list === null) {
				return;
			}

			$open = !$node->hasClass(static::CLASS_COLLAPSED);
			$attrs = $renderer->renderAttributeArray($renderer->sanitizeAttributes($node->getAttributes()));

			$event->setHtml(
				'<div' . $attrs . ">\n"
				. $this->renderList($list, $renderer, $open, 1)
				. "</div>\n",
			);
		});
	}

	/**
	 * The first list directly inside the container, or null when the body is not a list.
	 *
	 * @param \MarkupCarve\Carve\Node\Node $node Container node.
	 * @return \MarkupCarve\Carve\Node\Block\ListBlock|null
	 */
	protected function findList(Node $node): ?ListBlock {
		foreach ($node->getChildren() as $child) {
			if ($child instanceof ListBlock) {
				return $child;
			}
		}

		return null;
	}

	/**
	 * @param \MarkupCarve\Carve\Node\Block\ListBlock $list List to render.
	 * @param \MarkupCarve\Carve\Renderer\HtmlRenderer $renderer Active renderer.
	 * @param bool $open Whether branches start expanded.
	 * @param int $depth Indentation depth.
	 * @return string
	 */
	protected function renderList(ListBlock $list, HtmlRenderer $renderer, bool $open, int $depth): string {
		$pad = str_repeat('  ', $depth);
		$html = $pad . "<ul>\n";
		foreach ($list->getChildren() as $item) {
			if (!$item instanceof ListItem) {
				continue;
			}
			$html .= $this->renderItem($item, $renderer, $open, $depth + 1);
		}

		return $html . $pad . "</ul>\n";
	}

	/**
	 * A branch becomes a disclosure; a leaf stays a plain list item.
	 *
	 * @param \MarkupCarve\Carve\Node\Block\ListItem $item Item to render.
	 * @param \MarkupCarve\Carve\Renderer\HtmlRenderer $renderer Active renderer.
	 * @param bool $open Whether branches start expanded.
	 * @param int $depth Indentation depth.
	 * @return string
	 */
	protected function renderItem(ListItem $item, HtmlRenderer $renderer, bool $open, int $depth): string {
		$pad = str_repeat('  ', $depth);
		$label = $this->renderLabel($item, $renderer);
		$child = $this->findList($item);

		if ($child === null) {
			return $pad . '<li>' . $label . "</li>\n";
		}

		// A static render (print, PDF) never receives a click, so force every
		// branch open there - the same call DetailsExtension makes.
		$openAttr = $open || $renderer->isStaticMode() ? ' open' : '';

		return $pad . '<li><details' . $openAttr . '><summary>' . $label . "</summary>\n"
			. $this->renderList($child, $renderer, $open, $depth + 1)
			. $pad . "</details></li>\n";
	}

	/**
	 * The item's own inline content, without the nested list underneath it.
	 *
	 * @param \MarkupCarve\Carve\Node\Block\ListItem $item Item to label.
	 * @param \MarkupCarve\Carve\Renderer\HtmlRenderer $renderer Active renderer.
	 * @return string
	 */
	protected function renderLabel(ListItem $item, HtmlRenderer $renderer): string {
		foreach ($item->getChildren() as $child) {
			if ($child instanceof Paragraph) {
				return $renderer->renderInlineNodesFragment(array_values($child->getChildren()));
			}
		}

		return '';
	}

}
