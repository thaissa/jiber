<?php

/**
 * Manage user's settings, like Toggl token, Redmine
 * token, Jira and Basecamp username
 *
 * @author Thaissa Mendes <thaissa.mendes@gmail.com>
 * @since July 28, 2016
 * @version 0.1
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Setting;
use App\Http\Controllers\Toggl;
use App\Http\Controllers\Redmine;

class UsersController extends Controller
{
	/**
	 * Get setting record from DB, save it, and
	 * send to template
	 * Accept GET and POST calls
	 */
	public function settings(Request $request)
	{
		$setting = Setting::find($request->user()->id);

		if (!$setting)
		{
			$setting = new Setting;
			$setting->id = $request->user()->id;
			$setting->save();
		}

		if ($request->isMethod('post'))
		{
			$setting->id       = $request->user()->id;
			$setting->toggl    = $request->toggl;
			$setting->redmine  = $request->redmine;
			$setting->jira     = $request->jira;
			$setting->basecamp = $request->basecamp;
			$setting->save();
			$request->session()->flash('alert-success', 'Settings successfully saved.');
		}

		// These variables have three states:
		// -1: undefined
		//  0: error while connecting
		//  1: connected successfully
		$toggl = $redmine = $jira = $basecamp = -1;

		if ($setting->toggl)
			$toggl   = app('App\Http\Controllers\TogglController')  ->test($request);

		if ($setting->redmine)
			$redmine = app('App\Http\Controllers\RedmineController')->test($request);

		if ($setting->jira)
			$jira    = app('App\Http\Controllers\JiraController')   ->test($request);

		return view('users.settings', [
			'setting'  => $setting,
			'toggl'    => $toggl,
			'redmine'  => $redmine,
			'jira'     => $jira,
			'basecamp' => $basecamp,
		]);
	}
}
