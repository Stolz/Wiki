<?php

namespace App\Http\Requests;

class CreateLanguageRequest extends Request
{
	/**
	 * Class constructor.
	 *
	 * @param  array
	 * @return void
	 */
	public function __construct(array $rules = [])
	{
		parent::__construct([
			'code' => [_('Code'), 'required|size:2|regex:/^[a-z]+$/|unique:languages,code{excludeCurrentId}'],
			'name' => [_('Name'), 'required|max:255|unique:languages,name{excludeCurrentId}'],
			'native_name' => [_('Native name'), 'required|max:255|alpha|unique:languages,native_name{excludeCurrentId}'],
			'locale' => [_('Locale'), 'required|size:5|regex:/^[a-z]+_[A-Z]+$/'],
			'is_default' => [_('Default'), 'required|integer|min:0|max:1'],
		]);
	}
}
