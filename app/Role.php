<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	// Meta ========================================================================

	/**
	 * The attributes that are not mass-assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id', 'created_at', 'updated_at'];

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
		return _('Role');
	}

	/**
	 * Get the human-friendly plural name of the resource.
	 *
	 * @return string
	 */
	protected function getPluralAttribute()
	{
		return _('Roles');
	}

	// Relationships ===============================================================

	public function users()
	{
		return $this->hasMany('App\User');
	}

	// Events ======================================================================

	public static function boot()
	{
		// NOTE events cycle is as follows:
		// saving   -> creating -> created   -> saved
		// saving   -> updating -> updated   -> saved
		// deleting -> deleted  -> restoring -> restored

		parent::boot();

		static::updating(function ($role) {
			// Make sure to keep the only default role as default
			if($role->getOriginal('is_default') and ! $role->is_default)
				throw new DomainException(_('The defaulf status cannot be removed') . '. ' . _('Make another role the default one instead.'));
		});

		static::saved(function ($role) {
			// Only one role can be the default
			if($role->is_default)
				self::where('id', '<>', $role->id)->update(array('is_default' => 0));
		});
	}

	// Static Methods ==============================================================

	// Bussiness logic =============================================================

	/**
	 * Determine if $this role is authorized to execute $action on $resource.
	 *
	 * @param  string $action
	 * @param  string $resource
	 * @return bool
	 */
	public function can($action, $resource)
	{
		return true; //TODO Feel free to implement your own custom authorization system
	}
}
