<?php

namespace App\Http\Controllers\Web\Admin\UserConfig;

use App\Http\Controllers\Controller;
use App\Utils\FlashMessageHelper;
use App\Utils\ValidationHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Role::orderBy('name');
            return datatables()->of($query)
                ->addColumn('action', function ($data) {
                    if ($data->id == 1)
                        return 'Memiliki semua izin.';
                    return '<a class="btn btn-sm btn-success" href="' . route('admin.user_config.permission.show', [$data->id]) . '" data-toggle="tooltip" data-placement="top" title="Lihat Detail"><i class="far fa-eye"></i></a>';
                })
                ->editColumn('created_at', function ($data) {
                    return Carbon::parse($data->created_at)->format('d-m-Y');
                })
                ->make(true);
        }

        return view('admin.pages.user_configuration.permission.index');
    }

    public function show($id)
    {
        $data['role'] = Role::find($id);
        $data['rolePermissions'] = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->pluck('name', 'id');
        $data['permission'] = Permission::get();

        return view('admin.pages.user_configuration.permission.show', compact('data'));
    }

    public function update($id, Request $request)
    {
        $validator = ValidationHelper::validate(
            $request,
            [
                'permissions' => 'required|array',
                'name' => 'required'
            ],
            [],
            ['name' => 'Nama Peran']
        );
        if ($validator->fails()) {
            return ValidationHelper::validationError($validator);
        }

        $role = Role::find($id);
        $role->name = $request->name;

        foreach ($request->permissions as $permission) {
            $exists = Permission::where('guard_name', 'web')
                ->where('name', $permission)
                ->count();
            if (!$exists) {
                $perm = new Permission;
                $perm->name = $permission;
                $perm->guard_name = 'web';
                $perm->save();
            }
        }

        $role->syncPermissions($request->permissions);
        $role->save();

        FlashMessageHelper::bootstrapSuccessAlert('Berhasil merubah perizian ' . $request->name . '!');

        return redirect(route('admin.user_config.permission.index'));
    }

    public function delete($id)
    {
        $role = Role::find($id);
        $name = $role->name;
        $role->delete();
        FlashMessageHelper::alert(['class' => 'alert-success', 'icon' => 'trash', 'text' => 'Berhasil menghapus perizinan ' . $name . '!']);
        return redirect(route('admin.user_config.permission.index'));
    }

    public function createGet()
    {
        $data['permission'] = Permission::get();
        return view('admin.pages.user_configuration.permission.create', compact('data'));
    }

    public function createPost(Request $request)
    {
        $validator = ValidationHelper::validate(
            $request,
            [
                'permissions' => 'required|array',
                'name' => 'required|unique:permissions'
            ],
            [],
            ['name' => 'Nama Peran']
        );
        if ($validator->fails()) {
            return ValidationHelper::validationError($validator);
        }

        $role = Role::create([
            'name' => $request->name
        ]);

        foreach ($request->permissions as $permission) {
            $exists = Permission::where('guard_name', 'web')
                ->where('name', $permission)
                ->count();
            if (!$exists) {
                $perm = new Permission;
                $perm->name = $permission;
                $perm->guard_name = 'web';
                $perm->save();
            }
        }

        $role->syncPermissions($request->permissions);
        $role->save();

        FlashMessageHelper::bootstrapSuccessAlert('Berhasil menambahkan perizian ' . $request->name . '!');

        return redirect(route('admin.user_config.permission.index'));
    }
}
