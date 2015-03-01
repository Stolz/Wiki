<?php

/**
 * Convert from Markdown to HTML.
 *
 * @param  string
 * @return string
 */
function markdown($source)
{
	return with(new \League\CommonMark\CommonMarkConverter())->convertToHtml($source);
}

/**
 * Generate pagination links with a custom pagination rendered.
 *
 * @param  Illuminate\Contracts\Pagination\Presenter
 * @return string
 */
function pagination_links($presenter)
{
	return with(new \Stolz\LaravelFormBuilder\Pagination($presenter));
}

/**
 * Created an nested unordered list from a multidimensional array
 *
 * @param  array
 * @return string
 */
function tree(array $nodes, Closure $render = null)
{
	$output = '<ul>';
	foreach($nodes as $node)
	{
		// Get name
		$name = (is_null($render)) ? $node['name'] : $render($node);

		// Render node
		$output .= '<li>' . $name;

		// Render children
		if($node['children'])
			$output .= tree($node['children'], $render);

		$output .= '</li>';
	}

	return $output .'</ul>';
}
