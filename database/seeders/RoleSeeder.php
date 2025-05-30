<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Administrador']);
        // $role2 = Role::create(['name' => 'Estudiante']);

        Permission::create(['name' => 'admin.hierarchy.index', 'description' => 'Ver todas las configuraciones de jerarquia'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.setting.index', 'description' => 'Ver todas las configuraciones generales del sitio'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.roles.index', 'description' => 'Ver pagina de roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles.create', 'description' => 'Crear un rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles.destroy', 'description' => 'Borrar un rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles.store', 'description' => 'Guardar un rol'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.permissions.index', 'description' => 'Ver pagina de permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.permissions.create', 'description' => 'Crear un permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.permissions.destroy', 'description' => 'Borrar un permiso'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.permissions.store', 'description' => 'Guardar un permiso'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.roles-permissions.index', 'description' => 'Ver pagina de roles & permisos'])->syncRoles([$role1]);        
        Permission::create(['name' => 'admin.roles-permissions.permissions', 'description' => 'Asignar permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles-permissions.store', 'description' => 'Guardar asignación'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles-permissions.destroy', 'description' => 'Borrar asignación'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.users.index', 'description' => 'Ver listado de usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.create', 'description' => 'Crear un usuario'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.edit', 'description' => 'Editar un usuario'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.update', 'description' => 'Actualizar un usuario'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.destroy', 'description' => 'Borrar un usuario'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.store', 'description' => 'Guardar usuario'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.roles', 'description' => 'Asignar Roles'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.categories.index', 'description' => 'Ver listado de categorias'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.categories.create', 'description' => 'Crear categoria'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.categories.edit', 'description' => 'Editar categoria'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.categories.update', 'description' => 'Actualizar categoria'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.categories.destroy', 'description' => 'Borrar categoria'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.categories.store', 'description' => 'Guardar categoria'])->syncRoles([$role1]);
        
        Permission::create(['name' => 'admin.posts.index', 'description' => 'Ver listado de posts'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.posts.edit', 'description' => 'Editar post'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.posts.create', 'description' => 'Crear un post'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.posts.update', 'description' => 'Actualizar post'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.posts.destroy', 'description' => 'Borrar post'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.posts.store', 'description' => 'Guardar post'])->syncRoles([$role1]);
    }
}
