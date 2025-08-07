<?php

namespace App\Http\Livewire\Pages\Admin;

use Livewire\Component;
use App\Models\User;
use App\Http\Livewire\Pages\Admin\ExportUsers;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;
class ListUsers extends Component
{
    use WithFileUploads;
    use WithPagination;
    //Page
    public $paginate = 10;
    public $searchInput;
    protected $searchList;
    protected $pagination = 5;
    public $search = "";
    public $selectPage = false;
    public $checked = [];
    public $selectAll = false;
    
    public $SelectedStatusType = NULL;

    public $user_id = NULL;
    public $password;
    
    public function getUsersProperty()
    { 
        return $this->usersQuery
        ->orderBy('id', 'desc')
        ->paginate($this->paginate); 
    }
    
    public function getUsersQueryProperty()
    {
        return User::with(['status_type'])
            ->when($this->SelectedStatusType, function ($query) {
                $query->where('status_type_id', $this->SelectedStatusType);
            })
            ->search(trim($this->search));
    }
    
    public function render()
    {
        return view('livewire.pages.admin.list-users', [
            'users' => $this->users,
        ]);
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->users->pluck('id')->map(fn ($item) => (string) $item)->toArray();
        } else {
            $this->checked = [];
        }
    }

    public function updatedChecked()
    {
        $this->selectPage = false;
    }

    public function selectAll()
    {
        $this->selectAll = true;

        $this->checked = $this->usersQuery
        ->pluck('id')
        ->map(fn ($item) => (string) $item)
        ->toArray();     
    }

    public function exportSelected()
    {
        return Excel::download(new ExportUsers($this->checked), 'users.xls');
    }

    public function DeleteForm($user_id)
    {
        $this->user_id = $user_id;
        $this->password = '';
        $this->dispatchBrowserEvent('show-delete-form');
    }

    public function Delete()
    {
        $this->validate([
            'password' => 'required',
        ]);
        if (Hash::check($this->password, Auth::user()->password)) {
            $user = User::findOrFail($this->user_id);
            $user->delete();
            $this->checked = array_diff($this->checked, [$this->user_id]);
            $this->dispatchBrowserEvent('success-message', ['message' => 'Record Deleted successfully!']);
            return redirect()->back();
        } else {
            $this->dispatchBrowserEvent('error-message', ['message' => 'Incorrect Password']);
        }
    } 

    public function isChecked($user_id)
    {
        return in_array($user_id, $this->checked);
    }  
}
