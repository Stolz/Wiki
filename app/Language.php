<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DomainException;
use Session;

class Language extends Model
{
	use SoftDeletes;

	// Meta ========================================================================

	/**
	 * The attributes that are not mass-assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = ['is_default' => 'boolean'];

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
		return _('Language');
	}

	/**
	 * Get the human-friendly plural name of the resource.
	 *
	 * @return string
	 */
	protected function getPluralAttribute()
	{
		return _('Languages');
	}

	// Events ======================================================================

	public static function boot()
	{
		// NOTE events cycle is as follows:
		// saving   -> creating -> created   -> saved
		// saving   -> updating -> updated   -> saved
		// deleting -> deleted  -> restoring -> restored

		parent::boot();

		static::updating(function ($language) {
			// Make sure to keep the only default language as default
			if($language->getOriginal('is_default') and ! $language->is_default)
				throw new DomainException(_('The defaulf status cannot be removed') . '. ' . _('Make another language the default one instead.'));
		});

		static::saved(function ($language) {
			// Only one Language can be the default
			if($language->is_default)
				self::where('id', '<>', $language->id)->update(array('is_default' => 0));
		});
	}

	// Relationships ===============================================================

	public function users()
	{
		return $this->hasMany('App\User');
	}

	// Static Methods ==============================================================

	/**
	 * Detect the language that the application should use.
	 *
	 * @return Language
	 */
	public static function detect()
	{
		// Get all languages from database
		$all = self::orderBy('is_default', 'desc')->get();
		if( ! $all->count())
			return new static;

		// Helper function for adding information about where the language was detected from
		$addOrigin = function ($language, $origin) {
			$language->detectedFrom = $origin;

			return $language;
		};

		// Try with previous value from session
		if($language = Session::get('language') and isset($language->id) and $all->contains($language->id))
			return $addOrigin($all->find($language->id), 'session');

		// Try with user's browser language
		$language = with(new \Browser\Language)->getLanguageLocale('_');
		$type = (strlen($language) === 2) ? 'code' : 'locale';
		$languages = $all->where($type, $language);
		if($languages->count())
			return $addOrigin($languages->first(), 'browser');

		// Browser doesn't have any known language. Fallback to default
		return $addOrigin($all->first(), 'default');
	}

	/**
	 * Forget session language.
	 *
	 * @return void
	 */
	public static function forget()
	{
		Session::forget('language');
	}

	// Bussiness logic =============================================================

	/**
	 * Scope to filter by 'is_default' column.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder
	 * @param boolean
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeIsDefault($query, $isDefault = true)
	{
		$query->where('is_default', $isDefault);
	}

	/**
	 * Store session language.
	 *
	 * @return Language
	 */
	public function remember()
	{
		if($this->getKey())
			Session::put('language', (object) $this->toArray());

		return $this;
	}

	/**
	 * Set $this language as the application language
	 *
	 * @param  integer $category see http://php.net/manual/en/function.setlocale.php
	 * @param  boolean $force
	 * @return Language
	 */
	public function apply($category = LC_ALL, $force = false)
	{
		bindtextdomain('messages', base_path('resources/lang/'));
		textdomain('messages');
		$locale = $this->locale;

		$currentLocale = setlocale($category, "$locale.UTF-8", "$locale.utf-8", "$locale.utf8", "$locale UTF8", "$locale UTF-8", "$locale utf-8", "$locale utf8", "$locale UTF8", $locale);

		if($force and $currentLocale === false)
			abort(500, sprintf('Failed to set %s locale: The locale does not exist on your system, the category name is invalid or the locale functionality is not implemented on your platform.', $locale));

		return $this;
	}
}
