<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
	use SoftDeletes;

	// Meta ========================================================================

	/**
	 * The attributes that are not mass-assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id', 'login_count', 'created_at', 'updated_at', 'deleted_at'];

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
		return _('Provider');
	}

	/**
	 * Get the human-friendly plural name of the resource.
	 *
	 * @return string
	 */
	protected function getPluralAttribute()
	{
		return _('Providers');
	}

	// Relationships ===============================================================

	public function users()
	{
		return $this->hasMany('App\User');
	}

	// Events ======================================================================

	// Static Methods ==============================================================

	/**
	 * Get all usable providers.
	 *
	 * @return \Illuminate\Database\Eloquent\Collection (of AuthProvider)
	 */
	public static function getUsable()
	{
		return self::orderBy('name')->get()->filter(function ($provider) {
			return $provider->isUsable();
		});
	}

	// Bussiness logic =============================================================

	/**
	 * Determine if provider is enabled and has been configured in config/services.php file.
	 *
	 * @return boolean
	 */
	public function isUsable()
	{
		// Check database fields
		if( ! $this->id or empty($this->name) or empty($this->slug) or $this->trashed())
			return false;

		// Check config
		$config = config("services.{$this->slug}.client_id", config("services.{$this->slug}.client_secret"));

		return ! empty($config);
	}
}
