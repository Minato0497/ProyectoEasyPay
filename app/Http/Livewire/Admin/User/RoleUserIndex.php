<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RoleUserIndex extends Component
{
    use WithPagination;
    public $search;
    //public $users;
    public $roles;
    public $sortBy;
    public $sort = 'id';
    public $sortDirection  = 'asc';
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $users = User::where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate();
        $roles = Role::all();
        return view('livewire.admin.user.role-user-index', compact('users'));
    }

    public function order($sortBy)
    {
        if ($this->sortBy == $sortBy) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sortBY = $sortBy;
            $this->direction = 'asc';
        }
    }
    public function reverseSort()
    {
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }
    public function sortBy($field)
    {
        $this->sortDirection = $this->sortBy === $field
            ? $this->reverseSort()
            : 'asc';

        $this->sortBy = $field;
    }
}
