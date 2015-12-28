<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Socialite\Contracts\User as SocialUser;

class User extends Model implements AuthenticatableContract
{
	use Authenticatable, SoftDeletes;

	// Meta ========================================================================

	/**
	 * The attributes that are not mass-assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id', 'login_count', 'created_at', 'updated_at', 'deleted_at'];

	/**
	 * The attributes that are not visible.
	 *
	 * @var array
	 */
	protected $hidden = ['email'];

	/**
	 * What should be returned when this model is converted to string.
	 *
	 * @return string
	 */
	public function __toString()
	{
		if($this->nickname)
			return (string) $this->nickname;

		return (string) ($this->name) ?: $this->uuid;
	}

	/**
	 * Get the human-friendly singular name of the resource.
	 *
	 * @return string
	 */
	protected function getSingularAttribute()
	{
		return _('User');
	}

	/**
	 * Get the human-friendly plural name of the resource.
	 *
	 * @return string
	 */
	protected function getPluralAttribute()
	{
		return _('Users');
	}

	// Relationships ===============================================================

	public function language()
	{
		return $this->belongsTo('App\Language');
	}

	public function provider()
	{
		return $this->belongsTo('App\Provider');
	}

	public function role()
	{
		return $this->belongsTo('App\Role');
	}

	public function versions()
	{
		return $this->hasMany('App\Version');
	}

	// Events ======================================================================

	// Static Methods ==============================================================

	/**
	 * Create new user if it does not exists.
	 *
	 * @param  Provider
	 * @param  \Laravel\Socialite\Contracts\User
	 * @return User
	 */
	public static function findOrCreate(Provider $provider, SocialUser $socialUser)
	{
		// If user already exists reuse it
		$user = self::where([
			'uuid' => $socialUser->getId(),
			'provider_id' => $provider->id
		])->withTrashed()->first();

		if($user)
			return $user;

		// Create a new user
		$user = new static;
		$user->uuid = $socialUser->getId();
		$user->name = $socialUser->getName();
		$user->nickname = $socialUser->getNickname();
		$user->email = $socialUser->getEmail();
		$user->avatar = $socialUser->getAvatar();
		$user->provider_id = $provider->id;
		$user->language_id = app('language')->id;
		$user->role_id = Role::whereIsDefault(true)->firstOrFail()->id;
		$user->save();

		return $user;
	}

	// Bussiness logic =============================================================

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		// Social login does not need this feature
	}

	/**
	 * Determine if user's role is authorized to execute $action on $resource.
	 *
	 * @param  string $action
	 * @param  string $resource
	 * @return bool
	 */
	public function can($action, $resource)
	{
		return $this->role->can($action, $resource);
	}
}
