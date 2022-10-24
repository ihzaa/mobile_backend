<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\FlashMessageHelper;
use App\Utils\ValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.pages.user_profile');
    }

    public function update(Request $request)
    {

        $user = User::find(auth()->user()->id);
        $rules = [
            'name' => 'required',
            'email' => ['required', Rule::unique(User::getTableName())->ignore($user)],
        ];

        if ($request->old_password != null) {
            $rules['old_password'] = [
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail('Password Lama Salah!');
                    }
                },
            ];
            $rules['password'] = [
                'required', 'confirmed', 'min:8',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ];
            $rules['password_confirmation'] = 'required';
        }
        $validate = ValidationHelper::validate(
            $request,
            $rules,
            [
                'min' => ':attribute minimal terdiri dari :min karakter.',
                'confirmed' => 'Password konfirmasi tidak sama.',
                'regex' => 'Format password tidak sesuai.'
            ],
            ['name' => 'nama', 'old_password' => 'Password Lama']
        );

        $data = [
            'name' => $request->name,
            'email' => $request->email
        ];

        if ($request->old_password != null) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        FlashMessageHelper::bootstrapSuccessAlert('Berhasil Merubah Data.');

        return back();
    }
}
