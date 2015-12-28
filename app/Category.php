<?php

namespace App;

use Baum\Node as Model;

class Category extends Model
{
	// Meta ========================================================================

	/**
	 * The attributes that are not mass-assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id', 'parent_id', 'lft', 'rgt', 'depth', 'created_at', 'updated_at'];

	/**
	 * Column to perform the default sorting
	 *
	 * @var string
	 */
	protected $orderColumn = 'name';

	/**
	 * What should be returned when this model is converted to string.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->name;
	}

	/**
	 * Get the human-friendly singular name of the resource.
	 *
	 * @return string
	 */
	protected function getSingularAttribute()
	{
		return _('Category');
	}

	/**
	 * Get the human-friendly plural name of the resource.
	 *
	 * @return string
	 */
	protected function getPluralAttribute()
	{
		return _('Categories');
	}

	// Relationships ===============================================================

	public function pages()
	{
		return $this->hasMany('App\Page');
	}

	// Events ======================================================================

	// Static Methods ==============================================================

	/**
	 * Get all categories in a unidimensional array, ideal for being used in a form select dropdown.
	 *
	 * @param  boolean
	 * @return array
	 */
	public static function dropdown($includeRootNode = true)
	{
		$categories = self::getNestedList('name', null, '--');

		return ($includeRootNode) ? ['' => _('Root')] + $categories : $categories;
	}

	// Bussiness logic =============================================================
}
