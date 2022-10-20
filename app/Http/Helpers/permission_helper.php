<?php


use Illuminate\Support\Facades\DB;

function is_permission($role_id, $permission): bool
{
    return DB::table('acl_menus')
        ->join('acl_menu_permissions', 'acl_menu_permissions.menu_id', '=', 'acl_menus.id')
        ->where('acl_menu_permissions.role_id', '=', $role_id)
        ->where('acl_menus.menu_url', '=', $permission)
        ->exists();
}
