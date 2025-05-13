<?php
/**
 * @var \App\View\AppView $this
 * @var bool $_isSearch
 * @var iterable<\Sandbox\Model\Entity\Product> $products
 * @var \Sandbox\Model\Entity\Product $min
 * @var \Sandbox\Model\Entity\Product $max
 */
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/search'); ?>
</nav>
<div class="page index col-sm-8 col-12">


	<div class="products index content">
		<h2><?= __('Products') ?></h2>

		<?php echo $this->Form->create(null, ['valueSources' => 'query']); ?>

		<div class="box">
			<div class="values">
				Prices: <div>$<span id="first"></span></div> - <div>$<span id="second"></span></div>
			</div>
			<small>
				Current Range:
				<div>$<span id="third"></span></div>
			</small>

			<!-- Slider container -->
			<div
				class="slider"
				data-value-0="#first"
				data-value-1="#second"
				data-range="#third"
				data-input-0="#input-min"
				data-input-1="#input-max"
			></div>
		</div>

		<!-- Hidden inputs for form submission -->
		<?php
		echo $this->Form->hidden('price_min', ['id' => 'input-min', 'default' => (int)$min->price, 'secure' => false]);
		echo $this->Form->hidden('price_max', ['id' => 'input-max', 'default' => (int)ceil($max->price), 'secure' => false]);
		?>

		<style>
			body {
				&.ui-slider-active {
					cursor: grabbing;
				}
			}

			.box {
				--primary: #275efe;
				--headline: #3F4656;
				--text: #99A3BA;
				width: 100%;
				max-width: 312px;
				padding: 16px 16px 16px 16px;
				background: #fff;
				border-radius: 9px;
				box-shadow: 0 1px 4px rgba(18, 22, 33, .12);
				h3 {
					font-family: inherit;
					font-size: 32px;
					font-weight: 700;
					margin: 0 0 20px 0;
					color: var(--headline);
					span {
						font-weight: 500;
					}
				}
				.values,
				small {
					div {
						display: inline-block;
						vertical-align: top;
					}
				}
				.values {
					margin: 0;
					font-weight: 500;
					color: var(--primary);
					& > div {
						&:first-child {
							margin-right: 2px;
						}
						&:last-child {
							margin-left: 2px;
						}
					}
				}
				small {
					color: var(--text);
					display: block;
					margin-top: 8px;
					font-size: 14px;
				}
				.slider {
					margin-top: 10px;
				}
			}

			.slider {
				--primary: #275efe;
				--handle: #fff;
				--handle-active: #{mix(white, #275efe, 70%)};
				--handle-hover: #{mix(white, #275efe, 90%)};
				--handle-border: 2px solid var(--primary);
				--line: #cdd9ed;
				--line-active: var(--primary);
				height: 23px;
				width: 100%;
				position: relative;
				pointer-events: none;
				.ui-slider-handle {
					--y: 0;
					--background: var(--handle);
					cursor: grab;
					-webkit-tap-highlight-color: transparent;
					top: 0;
					width: 23px;
					height: 23px;
					transform: translateX(-50%);
					position: absolute;
					outline: none;
					display: block;
					pointer-events: auto;
					div {
						width: 23px;
						height: 23px;
						border-radius: 50%;
						transition: background .4s ease;
						border: var(--handle-border);
						background: var(--background);
					}
					&:hover {
						--background: var(--handle-hover);
					}
					&:active {
						--background: var(--handle-active);
						cursor: grabbing;
					}
				}
				svg {
					--stroke: var(--line);
					display: block;
					height: 83px;
					path {
						fill: none;
						stroke: var(--stroke);
						stroke-width: 1;
					}
				}
				.active,
				& > svg {
					position: absolute;
					top: -30px;
					height: 83px;
				}
				& > svg {
					left: 0;
					width: 100%;
				}
				.active {
					position: absolute;
					overflow: hidden;
					left: calc(var(--l) * 1px);
					right: calc(var(--r) * 1px);
					svg {
						--stroke: var(--line-active);
						position: relative;
						left: calc(var(--l) * -1px);
						right: calc(var(--r) * -1px);
						path {
							stroke-width: 2;
						}
					}
				}
			}

			.slider {
				position: relative;
				height: 8px;
				background: #ddd; /* gray background */
				border-radius: 4px;
				margin: 40px 0;
			}

			.slider .ui-slider-range {
				position: absolute;
				background: #007bff; /* blue selected range */
				height: 100%;
				top: 0;
				z-index: 1;
				border-radius: 4px;
			}

			.slider .ui-slider-handle {
				position: absolute;
				top: 50%;
				transform: translate(-50%, -50%);
				width: 20px;
				height: 20px;
				background: #fff;
				border: 2px solid #007bff;
				border-radius: 50%;
				cursor: pointer;
				z-index: 2;
			}
		</style>
		<?php $this->append('script'); ?>
		<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
		<script>
			$('.slider').each(function (e) {
				var slider = $(this),
					width = slider.width(),
					handle, handleObj;

				// Get input and span elements
				let input0 = $(slider.data('input-0'));
				let input1 = $(slider.data('input-1'));
				let display0 = $(slider.data('value-0'));
				let display1 = $(slider.data('value-1'));
				let rangeDisplay = $(slider.data('range'));

				// Get initial values from inputs or default
				let val0 = parseInt(input0.val()) || 1800;
				let val1 = parseInt(input1.val()) || 7800;

				slider.slider({
					range: true,
					values: [val0, val1],
					min: <?php echo (int)$min->price; ?>,
					step: <?php echo (int)(ceil($max->price) / 100); ?>,
					minRange: <?php echo (int)(ceil($max->price) / 10); ?>,
					max: <?php echo (int)ceil((float)$max->price); ?>,
					create(event, ui) {
						updateValues(val0, val1);
						setCSSVars(slider);
					},
					start(event, ui) {
						$('body').addClass('ui-slider-active');
						handle = $(ui.handle).data('index', ui.handleIndex);
						handleObj = slider.find('.ui-slider-handle');
					},
					slide(event, ui) {
						let min = slider.slider('option', 'min');
						let max = slider.slider('option', 'max');
						let minRange = slider.slider('option', 'minRange');

						if (ui.handleIndex === 0) {
							if ((ui.values[0] + minRange) >= ui.values[1]) {
								slider.slider('values', 1, ui.values[0] + minRange);
							}
							if (ui.values[0] > max - minRange) return false;
						} else if (ui.handleIndex === 1) {
							if ((ui.values[1] - minRange) <= ui.values[0]) {
								slider.slider('values', 0, ui.values[1] - minRange);
							}
							if (ui.values[1] < min + minRange) return false;
						}

						updateValues(ui.values[0], ui.values[1]);
						setCSSVars(slider);
					},
					change(event, ui) {
						updateValues(ui.values[0], ui.values[1]);
						setCSSVars(slider);
					},
					stop(event, ui) {
						$('body').removeClass('ui-slider-active');
						let duration = 0.6;
						let ease = Elastic.easeOut.config(1.08, 0.44);

						handle = null;
					}
				});

				// Update UI + form inputs
				function updateValues(v0, v1) {
					display0.html(formatNumber(v0));
					display1.html(formatNumber(v1));
					rangeDisplay.html(formatNumber(v1 - v0));
					input0.val(v0);
					input1.val(v1);
				}

				// Format numbers with thin space
				function formatNumber(num) {
					return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '&thinsp;');
				}

				function setCSSVars(slider) {
					let handle = slider.find('.ui-slider-handle');
					slider.css({
						'--l': handle.eq(0).position().left + handle.eq(0).outerWidth() / 2,
						'--r': slider.outerWidth() - (handle.eq(1).position().left + handle.eq(1).outerWidth() / 2)
					});
				}

				// Wavy path animation setup
				var svgPath = new Proxy({ x: null, y: null, b: null, a: null }, {
					set(target, key, value) {
						target[key] = value;
						if (target.x !== null && target.y !== null && target.b !== null && target.a !== null) {
							slider.find('svg').html(getPath([target.x, target.y], target.b, target.a, width));
						}
						return true;
					}
				});

				svgPath.x = width / 2;
				svgPath.y = 42;
				svgPath.b = 0;
				svgPath.a = width;

				$(document).on('mousemove touchmove', e => {
					if (handle) {
						let laziness = 4,
							max = 24,
							edge = 52,
							other = handleObj.eq(handle.data('index') === 0 ? 1 : 0),
							currentLeft = handle.position().left,
							otherLeft = other.position().left,
							handleWidth = handle.outerWidth(),
							handleHalf = handleWidth / 2,
							y = e.pageY - handle.offset().top - handle.outerHeight() / 2,
							moveY = (y - laziness >= 0) ? y - laziness : (y + laziness <= 0) ? y + laziness : 0,
							modify = 1;

						moveY = 0;
						modify = handle.data('index') === 0
							? ((currentLeft + handleHalf <= edge ? (currentLeft + handleHalf) / edge : 1) * (otherLeft - currentLeft - handleWidth <= edge ? (otherLeft - currentLeft - handleWidth) / edge : 1))
							: ((currentLeft - (otherLeft + handleHalf * 2) <= edge ? (currentLeft - (otherLeft + handleWidth)) / edge : 1) * (slider.outerWidth() - (currentLeft + handleHalf) <= edge ? (slider.outerWidth() - (currentLeft + handleHalf)) / edge : 1));

						modify = Math.max(0, Math.min(modify, 1));

						if (handle.data('index') === 0) {
							svgPath.b = currentLeft / 2 * modify;
							svgPath.a = otherLeft;
						} else {
							svgPath.b = otherLeft + handleHalf;
							svgPath.a = (slider.outerWidth() - currentLeft) / 2 + currentLeft + handleHalf + ((slider.outerWidth() - currentLeft) / 2) * (1 - modify);
						}

						svgPath.x = currentLeft + handleHalf;
						svgPath.y = moveY * modify + 42;
						handle.css('--y', 0);
					}
				});
			});

			// Generate SVG path for wave
			function getPoint(point, i, a, smoothing) {
				let cp = (current, previous, next, reverse) => {
					let p = previous || current,
						n = next || current,
						o = {
							length: Math.sqrt(Math.pow(n[0] - p[0], 2) + Math.pow(n[1] - p[1], 2)),
							angle: Math.atan2(n[1] - p[1], n[0] - p[0])
						},
						angle = o.angle + (reverse ? Math.PI : 0),
						length = o.length * smoothing;
					return [current[0] + Math.cos(angle) * length, current[1] + Math.sin(angle) * length];
				};
				let cps = cp(a[i - 1], a[i - 2], point, false),
					cpe = cp(point, a[i - 1], a[i + 1], true);
				return `C ${cps[0]},${cps[1]} ${cpe[0]},${cpe[1]} ${point[0]},${point[1]}`;
			}

			function getPath(update, before, after, width) {
				let smoothing = 0.16,
					points = [
						[0, 42],
						[before <= 0 ? 0 : before, 42],
						update,
						[after >= width ? width : after, 42],
						[width, 42]
					];
				return `<path d="${points.reduce((acc, point, i, a) => i === 0 ? `M ${point[0]},${point[1]}` : `${acc} ${getPoint(point, i, a, smoothing)}`, '')}" />`;
			}

		</script>
		<?php $this->end(); ?>

		<?php echo $this->Form->button(__('Filter'), ['div' => false, 'style' => 'width: 200px;']); ?>

		<?php if ($this->Search->isSearch()) {
			echo $this->Search->resetLink(null, ['class' => 'btn btn-outline-secondary']);
		} ?>

		<?php echo $this->Form->end(); ?>



		<div class="table-responsive">
			<table class="table">
				<thead>
				<tr>
					<th><?= $this->Paginator->sort('title') ?></th>
					<th><?= $this->Paginator->sort('price') ?></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($products as $product): ?>
					<tr>
						<td><?= h($product->title) ?></td>
						<td><?= $this->Number->currency($product->price, 'EUR') ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="paginator">
			<ul class="pagination">
				<?= $this->Paginator->first('<< ' . __('first')) ?>
				<?= $this->Paginator->prev('< ' . __('previous')) ?>
				<?= $this->Paginator->numbers() ?>
				<?= $this->Paginator->next(__('next') . ' >') ?>
				<?= $this->Paginator->last(__('last') . ' >>') ?>
			</ul>
			<p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
		</div>
	</div>

</div>
