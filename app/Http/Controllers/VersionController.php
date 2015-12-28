<?php

namespace App\Http\Controllers;

use App\Page;
use App\Version;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use URL;

class VersionController extends Controller
{
	/**
	 * Display a listing of versions of a page.
	 *
	 * @param  integer
	 * @return Response
	 */
	public function index($pageId)
	{
		// Make sure page exists
		$page = Page::findOrFail($pageId);

		// Load view
		return view('version.index', [
			'title' => _('Versions'),
			'subtitle' => $page,
			'versions' => $page->versions()->latest()->with('user')->paginate(),
			'compareUrl' => route('page.version.show', [$page->id]),
			'returnUrl' => (false !== strpos(URL::previous(), '?page=')) ? URL::previous() : route('page.show', [$page->id]),
		]);
	}

	/**
	 * If one version is provided, show version.
	 * If two versions are provide, compare them.
	 *
	 * @param  int      $pageId
	 * @param  string   $versionIds
	 * @return Response
	 */
	public function show($pageId, $versionIds)
	{
		// Make sure page exists
		$page = Page::findOrFail($pageId);

		// Make sure no more than two version ids are used
		$versionIds = array_slice(explode('-', $versionIds), 0, 2);

		// Get versions with oldest first
		$versions = $page->versions()->whereIn('id', $versionIds)->oldest()->with('user')->get();

		$count = $versions->count();

		if($count === 0)
			throw with(new ModelNotFoundException)->setModel('App\Version');

		// Compare versions
		if($count === 2)
			return $this->compareVersions($versions->first(), $versions->last());

		// Show single version
		return view('version.show', [
			'version'  => $version = $versions->first(),
			'title'    => $version->singular,
			'subtitle' => $version->name,
		]);
	}

	/**
	 * Show difference between two versions.
	 *
	 * @param  \App\Version
	 * @param  \App\Version
	 * @return void
	 */
	protected function compareVersions(Version $before, Version $after)
	{
		// Parse source
		$beforeArray = explode("\n", $before->source);
		$afterArray = explode("\n", $after->source);

		// Compare versions
		$diff = new \Diff($beforeArray, $afterArray, $options = [
			//'context' => 3,
			//'ignoreNewLines' => false,
			//'ignoreWhitespace' => false,
			//'ignoreCase' => false
		]);

		// Load view
		return view('version.compare', [
			'title' => _('Versions'),
			'subtitle' => _('Compare'),
			'before' => $before,
			'after' => $after,
			'sideBySideDiff' => $diff->Render(new \Diff_Renderer_Html_SideBySide),
			'inlineDiff' => $diff->render(new \Diff_Renderer_Html_Inline),
		]);
	}
}
