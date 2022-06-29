<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $role = Role::create(['name' => 'admin']);

        $permissions = [
            [
                'group_name' => 'fleet',
                'permission' => [
                    'fleet.view',
                    'fleet.create',
                    'fleet.edit',
                    'fleet.delete',
                ]
            ],
            [
                'group_name' => 'vehicle',
                'permission' => [
                    'vehicle.view',
                    'vehicle.create',
                    'vehicle.edit',
                    'vehicle.delete',
                ]
            ],
            [
                'group_name' => 'desti',
                'permission' => [
                    'desti.view',
                    'desti.create',
                    'desti.edit',
                    'desti.delete',
                ]
            ],
            [
                'group_name' => 'route',
                'permission' => [
                    'route.view',
                    'route.create',
                    'route.edit',
                    'route.delete',
                ]
            ],
            [
                'group_name' => 'schedule',
                'permission' => [
                    'schedule.view',
                    'schedule.create',
                    'schedule.edit',
                    'schedule.delete',
                ]
            ],
            [
                'group_name' => 'trip',
                'permission' => [
                    'trip.view',
                    'trip.create',
                    'trip.edit',
                    'trip.delete',
                ]
            ],
            [
                'group_name' => 'user',
                'permission' => [
                    'user.view',
                    'user.create',
                    'user.edit',
                    'user.delete',
                ]
            ],
            [
                'group_name' => 'role',
                'permission' => [
                    'role.view',
                    'role.create',
                    'role.edit',
                    'role.delete',
                ]
            ]
        ];

        for ($i = 0; $i < count($permissions); $i++) {
            $groupName = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permission']); $j++) {
                $permission = Permission::create(['name' => $permissions[$i]['permission'][$j], 'group_name' => $groupName]);
                $role->givePermissionTo($permission);
                $permission->assignRole($role);
            }
        }
    }
}
