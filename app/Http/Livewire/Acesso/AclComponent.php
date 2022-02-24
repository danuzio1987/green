<?php

namespace App\Http\Livewire\Acesso;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AclComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ["deleteRole", "deletePermission"];

    /**ROLES */
    public $role_name;
    public $role_form;
    public $actual_role;

    /**PERMISSIONS */
    public $permission_name;
    public $permission_form;
    public $actual_permission;

    /**VINCULAÇÃO */
    public $role_id;
    public $permission_id;

    public $role_count;
    public $permission_count;

    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        //roles
        $this->role_name = "";
        $this->role_form = "create";
        $this->actual_role = null;
        //permissions
        $this->permission_name = "";
        $this->permission_form = "create";
        $this->actual_permission = null;
        //vinculaçoes
        $this->role_id = "";
        $this->permission_id = "";

        $this->role_count = Role::all();
        $this->permission_count = Permission::all();
    }

    /** ROLES */
    public function createRole()
    {
        $customMessages = [
            'role_name.required'  => '✋ Fala sério... este campo é obrigatório!!!',
        ];

        $this->validate([
            'role_name' => 'required'
        ], $customMessages);

        Role::create([
            'name' => $this->role_name
        ]);

        $this->dispatchBrowserEvent("role-created");
        $this->start();
    }

    public function showEditFormRole($role_id)
    {
        $this->role_form = "edit";
        $this->actual_role = Role::findOrFail($role_id);
        $this->role_name = $this->actual_role->name;
    }

    public function updateRole()
    {
        $customMessages = [
            'role_name.required'  => '✋ Fala sério... este campo é obrigatório!!!',
        ];

        $this->validate([
            'role_name' => 'required'
        ], $customMessages);

        $this->actual_role->name = $this->role_name;
        $this->actual_role->update();
        $this->dispatchBrowserEvent("role-updated");
        $this->start();
    }

    public function cancel()
    {
        $this->start();
    }

    public function confirmationDeleteRole($role_id)
    {
        $this->actual_role = Role::findOrFail($role_id);
        $this->dispatchBrowserEvent("role-delete-confirmation");
    }

    public function deleteRole()
    {
        $this->actual_role->delete();
        $this->dispatchBrowserEvent("role-deleted");
    }
    /** PERMISSIONS */
    public function createPermission()
    {
        $customMessages = [
            'permission_name.required'  => '✋ Fala sério... este campo é obrigatório!!!',
        ];

        $this->validate([
            'permission_name' => 'required'
        ], $customMessages);

        Permission::create([
            'name' => $this->permission_name
        ]);

        $this->dispatchBrowserEvent("permission-created");
        $this->start();
    }

    public function showEditFormPermission($permission_id)
    {
        $this->permission_form = "edit";
        $this->actual_permission = Permission::findOrFail($permission_id);
        $this->permission_name = $this->actual_permission->name;
    }

    public function updatePermission()
    {
        $customMessages = [
            'permission_name.required'  => '✋ Fala sério... este campo é obrigatório!!!',
        ];

        $this->validate([
            'permission_name' => 'required'
        ], $customMessages);

        $this->actual_permission->name = $this->permission_name;
        $this->actual_permission->update();
        $this->dispatchBrowserEvent("permission-updated");
        $this->start();
    }

    public function confirmationDeletePermission($permission_id)
    {
        $this->actual_permission = Permission::findOrFail($permission_id);
        $this->dispatchBrowserEvent("permission-delete-confirmation");
    }

    public function deletePermission()
    {
        $this->actual_permission->delete();
        $this->dispatchBrowserEvent("permission-deleted");
    }

    /** VINCULAÇÕES */
    public function relacionar()
    {
        $role = Role::findOrFail($this->role_id);
        $permission = Permission::findOrFail($this->permission_id);
        $role->givePermissionTo($permission);
        $this->start();
        $this->dispatchBrowserEvent("vinculo-created");
    }

    public function removePermission($role_id, $permission_id)
    {
        $this->actual_role = Role::findOrFail($role_id);
        $this->actual_permission = Permission::findOrFail($permission_id);
        $this->actual_role->revokePermissionTo($this->actual_permission);
        $this->dispatchBrowserEvent("vinculo-deleted");

    }

    public $paginate = 5;

    public function render()
    {
        return view('livewire.acesso.acl-component', [
            "roles" => Role::paginate($this->paginate),
            "permissions" => Permission::paginate($this->paginate)
        ]);
    }
}
