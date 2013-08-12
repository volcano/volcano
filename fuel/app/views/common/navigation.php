<?php if (!empty($options['navbar'])): ?><div class="navbar"><div class="navbar-inner"><?php endif ?>
	<ul class="nav<?php if (!empty($options['class'])) echo ' ' . $options['class'] ?>">
		<?php
		foreach ($items as $item) {
			if (!isset($item['href']) || !isset($item['value'])) {
				continue;
			}
			
			$value = $item['value'];
			
			if (!empty($item['icon'])) {
				$value = '<i class="icon ' . $item['icon'] . '"></i> ' . $value;
			}
			
			if (!empty($item['external'])) {
				$value .= ' <i class="icon icon-external-link"></i>';
			}
			
			$active = false;
			
			// Parse href value.
			if(preg_match("#^(http|https)://#i", $item['href']) && empty($item['external'])) {
				$href_parts = parse_url($item['href']);
				$item['href'] = ltrim($href_parts['path'], '/');
			}
			
			// Check for forced active.
			if (!empty($item['active'])) {
				$active = true;
			}
			// Check for exact match.
			else if ($item['href'] == Request::active()->uri) {
				$active = true;
			}
			// Check for wildcard match.
			else if (!empty($item['aliases'])) {
				foreach ((array) $item['aliases'] as $alias) {
					if ($alias == Request::active()->uri) {
						$active = true;
						break;
					}
					else if ('*' === substr($alias, -1)) {
						$new_alias = substr($alias, 0, -1);
						if (0 === stripos(Request::active()->uri, $new_alias)) {
							$active = true;
							break;
						}
					}
				}
			}
			
			$attributes = array();
			if (!empty($item['attributes'])) {
				$attributes = $item['attributes'];
			}
			
			$nav_classes = array();
			if ($active) {
				$nav_classes[] = 'active';
			}
			
			if (!empty($item['class'])) {
				$nav_classes[] = $item['class'];
			}
			
			$nav_class = implode(' ', $nav_classes);
			?>
			
			<li<?php if (!empty($nav_class)): ?> class="<?php echo $nav_class ?>"<?php endif ?>>
				<?php echo Html::anchor($item['href'], $value, $attributes) ?>
			</li>
			<?php
		}
		?>
	</ul>
<?php if (!empty($options['navbar'])): ?></div></div><?php endif ?>
