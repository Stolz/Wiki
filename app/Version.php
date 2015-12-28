<?php

namespace App;

use Request;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
	// Meta ========================================================================

	/**
	 * The attributes that are not mass-assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['*'];

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
		return _('Version');
	}

	/**
	 * Get the human-friendly plural name of the resource.
	 *
	 * @return string
	 */
	protected function getPluralAttribute()
	{
		return _('Versions');
	}

	// Relationships ===============================================================

	public function page()
	{
		return $this->belongsTo('App\User');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	// Events ======================================================================

	// Static Methods ==============================================================

	/**
	 * Create version from existing page.
	 *
	 * @return bool
	 */
	public static function createFromPage(Page $page)
	{
		$version = new static;
		$version->name = $page->name;
		$version->source = $page->source;
		$version->ip_address = Request::getClientIp();
		$version->page_id = $page->id;
		$version->user_id = auth()->user()->id;

		return $version->save();
	}

	// Bussiness logic =============================================================
}
