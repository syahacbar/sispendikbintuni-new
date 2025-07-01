<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $super = Role::findByName('super_admin');
        $dinas = Role::findByName('admin_dinas');
        $sekolah = Role::findByName('admin_sekolah');

        $allPermissions = Permission::all();

        $super->syncPermissions($allPermissions);

        $dinas->syncPermissions(
            $allPermissions->filter(
                fn($p) =>
                !str_contains($p->name, 'role') &&
                    !str_contains($p->name, 'permission') &&
                    !str_contains($p->name, 'setting')
            )
        );

        $sekolah->syncPermissions(
            $allPermissions->filter(
                fn($p) =>
                str_contains($p->name, 'siswa') ||
                    str_contains($p->name, 'guru') ||
                    str_contains($p->name, 'sarana')
            )
        );
    }
}
