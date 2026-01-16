<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CleanupPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar permission yang akan dipertahankan (hanya CRUD)
        $allowedPrefixes = ['view_any_', 'create_', 'update_', 'delete_'];

        // Ambil semua permission
        $allPermissions = Permission::all();

        foreach ($allPermissions as $permission) {
            $shouldKeep = false;

            // Cek apakah permission ini termasuk yang dipertahankan
            foreach ($allowedPrefixes as $prefix) {
                if (str_starts_with($permission->name, $prefix)) {
                    $shouldKeep = true;
                    break;
                }
            }

            // Cek jika ini permission untuk page atau widget (pertahankan)
            if (
                str_starts_with($permission->name, 'page_') ||
                str_starts_with($permission->name, 'widget_')
            ) {
                $shouldKeep = true;
            }

            // Hapus jika bukan termasuk yang dipertahankan
            if (!$shouldKeep) {
                echo "Deleting permission: {$permission->name}\n";
                $permission->delete();
            }
        }

        echo "\nPermission cleanup completed!\n";
    }
}
