<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }
    public function index()
    {
        $data = [
            'user' => $this->user->findOrFail(Auth::user()->id),
        ];

        return view('profile.index', $data);
    }

    public function edit($role, $id)
    {
        $data['user'] = $this->user->find($id);

        return view('profile.edit', $data);
    }

    public function update(Request $request, $role)
    {
        DB::beginTransaction();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            // 'email' => 'required|email',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            DB::rollBack();
            return back()->with('error', $validator->errors()->first());
        }

        try {
            $user = $this->user->findOrFail(Auth::id());

            $data = $request->only(['name', 'email', 'birth_date', 'gender', 'phone', 'address']);

            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $filename = time() . '-' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads/profile', $filename, 'public');

                $data['profile_image'] = 'storage/' . $path;
            }

            $user->update($data);

            DB::commit();
            return back()->with('success', 'Profile has been updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong while updating.');
        }
    }
}
