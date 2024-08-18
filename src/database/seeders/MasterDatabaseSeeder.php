<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use DateTime;

class MasterDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ユーザー作成
        $administer = User::create([
            'name' => '管理者1',
            'email' => 'admin1@test.com',
            'email_verified_at' => new DateTime(),
            'password' => bcrypt('password'),
            ]);

        $representative = User::create([
            'name' => '店舗代表者1',
            'email' => 'represent1@test.com',
            'email_verified_at' => new DateTime(),
            'password' => bcrypt('password'),
            ]);

        User::create([
            'name' => '利用者1',
            'email' => 'user1@test.com',
            'email_verified_at' => new DateTime(),
            'password' => bcrypt('password'),
            ]);


        // ロール作成
        $adminRole = Role::create(['name' => 'admin']);
        $representRole = Role::create(['name' => 'represent']);

        // 権限作成
        $registerRepresentPermission = Permission::create(['name' => 'registerRepresent']);
        $registerShopPermission = Permission::create(['name' => 'registerShop']);
        $updateShopPermission = Permission::create(['name' => 'updateShop']);
        $checkReservePermission = Permission::create(['name' => 'checkReserve']);

        // admin役割にregisterRepresent権限を付与
        $adminRole->givePermissionTo($registerRepresentPermission);
        // represent役割に権限を付与
        $representRole->givePermissionTo($registerShopPermission);
        $representRole->givePermissionTo($updateShopPermission);
        $representRole->givePermissionTo($checkReservePermission);

        // 管理者にadmin役割を割り当て
        $administer->assignRole($adminRole);
    }
}
