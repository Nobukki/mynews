<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profiles;

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

    public function update()
    {
        return redirect('admin/profile/edit');
    }

}
