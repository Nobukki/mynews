<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profiles;
use App\ProfileHistory;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function add()
    {
        return view('admin.profile.create');
    }

    public function create(Request $request)
    {
        $this->validate($request, Profiles::$rules);

        $profile = new Profiles;
        $form = $request->all();

        unset($form['_token']);
        unset($form['image']);

        $profile->fill($form);
        $profile->save();

        return redirect('admin/profile/create');
    }

    public function edit(Request $request)
    {
        $profile = Profiles::find($request->id);
        if (empty($profile)) {
            abort(404);    
        }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }

    public function update(Request $request)
    {
        $this->validate($request, Profiles::$rules);
        $profile = Profiles::find($request->input('id'));
        $profile_form = $request->all();
        // if ($request->input('remove')) {
        //     $profile_form['image_path'] = null;
        // } elseif ($request->file('image')) {
        //     $path = $request->file('image')->store('public/image');
        //     $profile_form['image_path'] = basename($path);
        // } else {
        //     $profile_form['image_path'] = $profile->image_path;
        // }

        unset($profile_form['_token']);
        unset($profile_form['image']);
        unset($profile_form['remove']);
        $profile->fill($profile_form)->save();

        // 以下を追記
        $history = new ProfileHistory();
        $history->profile_id = $profile->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/profile/edit');
    }

}
