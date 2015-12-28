<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
	use SoftDeletes;

	// Meta ========================================================================

	/**
	 * The attributes that are not mass-assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id', 'markup', 'created_at', 'updated_at', 'deleted_at'];

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
		return _('Page');
	}

	/**
	 * Get the human-friendly plural name of the resource.
	 *
	 * @return string
	 */
	protected function getPluralAttribute()
	{
		return _('Pages');
	}

	// Relationships ===============================================================

	public function category()
	{
		return $this->belongsTo('App\Category');
	}

	public function latestVersion()
	{
		return $this->hasOne('App\Version')->latest();
	}

	public function versions()
	{
		return $this->hasMany('App\Version');
	}

	// Events ======================================================================

	public static function boot()
	{
		// NOTE events cycle is as follows:
		// saving   -> creating -> created   -> saved
		// saving   -> updating -> updated   -> saved
		// deleting -> deleted  -> restoring -> restored

		parent::boot();

		static::saved(function ($page) {
			// Build markup
			$markup = markup($page->source);
			self::where([$page->getKeyName() => $page->getKey()])->limit(1)->update(['markup' => $markup]);

			// Backup version
			return Version::createFromPage($page);
		});
	}

	// Accessors / Mutators ========================================================

	// Static Methods ==============================================================

	// Bussiness logic =============================================================
}
