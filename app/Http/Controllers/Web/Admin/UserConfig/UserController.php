<?php

namespace App\Http\Controllers\Web\Admin\UserConfig;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\Password;
use App\Utils\FlashMessageHelper;
use App\Utils\ValidationHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (request()->has('deleted')) {
                $query = User::onlyTrashed();
            } else {
                $query = User::query();
            }
            return datatables()->of($query)
                ->addColumn('status', function ($obj) {
                    if ($obj->trashed()) {
                        return 'Dihapus';
                    } else {
                        return 'Aktif';
                    }
                })
                ->addColumn('action', function ($obj) {
                    return '<a class="btn btn-sm btn-success" href="' . route('admin.user_config.user.show', ['id' => $obj->id]) . '" data-toggle="tooltip" data-placement="top" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                })
                ->editColumn('created_at', function ($data) {
                    return Carbon::parse($data->created_at)->format('d-m-Y');
                })
                ->make(true);
        }
        $data['model'] = User::class;
        return view('admin.pages.user_configuration.user.index', compact('data'));
    }

    public function createGet()
    {
        $data['roles'] = Role::get();
        $data['user_type'] = User::user_type;
        return view('admin.pages.user_configuration.user.create', compact('data'));
    }

    public function createPost(Request $request)
    {
        $validate = ValidationHelper::validate($request, [
            'name' => 'required',
            'username' => 'required|unique:' . User::getTableName(),
            'email' => 'required|email|unique:' . User::getTableName(),
            'password' => [
                'required', 'min:8',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
            'role' => 'required',
            'user_type' => 'required'
        ], ['min' => ':attribute Minimal terdiri dari :min karakter'], [
            'name' => 'nama',
            'role' => 'peran',
            'user_type' => 'Tipe User'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_type = $request->user_type;

        $role = Role::find($request->role);
        $user->assignRole($role);
        $user->save();

        FlashMessageHelper::bootstrapSuccessAlert('User ' . $request->name . ' berhasil ditambahkan!', 'Berhasil!');

        return redirect(route('admin.user_config.user.index'));
    }

    public function show($id)
    {
        $data['obj'] = User::withTrashed()->find($id);
        $data['roles'] = Role::pluck('name', 'id');
        $data['user_role'] = $data['obj']->getRoleNames();
        $data['user_type'] = User::user_type;
        return view('admin.pages.user_configuration.user.show', compact('data'));
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $validate = ValidationHelper::validate($request, [
            'name' => 'required',
            'email' => ['required', Rule::unique(User::getTableName())->ignore($user)],
            'password' => [
                'nullable', 'min:8',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
            'role' => 'required',
            'user_type' => 'required'
        ], ['min' => ':attribute Minimal terdiri dari :min karakter'], ['name' => 'nama', 'role' => 'peran', 'user_type' => 'Tipe User']);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('role'));
        $user->save();

        FlashMessageHelper::bootstrapSuccessAlert('User ' . $request->name . ' berhasil diubah!', 'Berhasil!');

        return back();
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        FlashMessageHelper::bootstrapSuccessAlert('User ' . $user->name . ' berhasil dihapus!');

        return redirect(route('admin.user_config.user.index'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->first();
        $user->restore();

        FlashMessageHelper::bootstrapSuccessAlert('User ' . $user->name . ' berhasil dikembalikan!');

        return redirect(route('admin.user_config.user.show', ['id' => $id]));
    }
}
