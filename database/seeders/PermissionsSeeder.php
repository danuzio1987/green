<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            "edit_usina",
            "edit_armazem",
            "edit_fornecedor",
            "edit_cliente",
            "edit_insumo",
            "edit_produto",
            "edit_tancagem",
            "edit_pedido",
            "edit_venda",
            "edit_transferencia",
            "edit_ajuste",
            "edit_emprestimo",
            "edit_perfil",
            "edit_permissoes"
        ];

        foreach ($names as $key => $name) {
            Permission::create([
                "name" => $name
            ]);
        }

        //Vinculações do SUPER ADMIN
        $super_admin = Role::findByName("Super Admin");
        foreach ($names as $key => $name) {
            $super_admin->givePermissionTo(Permission::findByName($name));
        }

        //Vinculações do ADMIN
        $admin = Role::findByName("Admin");
        $admin->givePermissionTo(Permission::findByName("edit_usina"));
        $admin->givePermissionTo(Permission::findByName("edit_armazem"));
        $admin->givePermissionTo(Permission::findByName("edit_fornecedor"));
        $admin->givePermissionTo(Permission::findByName("edit_cliente"));
        $admin->givePermissionTo(Permission::findByName("edit_insumo"));
        $admin->givePermissionTo(Permission::findByName("edit_produto"));
        $admin->givePermissionTo(Permission::findByName("edit_tancagem"));
        $admin->givePermissionTo(Permission::findByName("edit_pedido"));
        $admin->givePermissionTo(Permission::findByName("edit_venda"));
        $admin->givePermissionTo(Permission::findByName("edit_transferencia"));
        $admin->givePermissionTo(Permission::findByName("edit_ajuste"));
        $admin->givePermissionTo(Permission::findByName("edit_emprestimo"));
        $admin->givePermissionTo(Permission::findByName("edit_perfil"));

        //Vinculações DIRETORIA
        $diretoria = Role::findByName("Diretoria");
        $diretoria->givePermissionTo(Permission::findByName("edit_pedido"));
        $diretoria->givePermissionTo(Permission::findByName("edit_venda"));
        $diretoria->givePermissionTo(Permission::findByName("edit_perfil"));

        //Vinculações OPERAÇÂO
        $operacao = Role::findByName("Operação");
        $operacao->givePermissionTo(Permission::findByName("edit_fornecedor"));
        $operacao->givePermissionTo(Permission::findByName("edit_cliente"));
        $operacao->givePermissionTo(Permission::findByName("edit_pedido"));
        $operacao->givePermissionTo(Permission::findByName("edit_venda"));
        $operacao->givePermissionTo(Permission::findByName("edit_transferencia"));
        $operacao->givePermissionTo(Permission::findByName("edit_ajuste"));
        $operacao->givePermissionTo(Permission::findByName("edit_emprestimo"));




    }
}
