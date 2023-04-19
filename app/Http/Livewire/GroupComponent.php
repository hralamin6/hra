<?php

namespace App\Http\Livewire;

use App\Models\Group;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class GroupComponent extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $group;
    public $name, $overview, $description, $status='active';
    public $selectedRows = [];
    public $selectPageRows = false;
    public $itemPerPage;
    public $orderBy = 'id';
    public $searchBy = 'id';
    public $orderDirection = 'asc';
    public $search = '';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $listeners = ['deleteMultiple', 'deleteSingle'];

    public function loadData(Group $group)
    {
        $this->reset('name', 'status');
        $this->emit('openEditModal');
        $this->name = $group->name;
        $this->overview = $group->overview;
        $this->description = $group->description;
        $this->status = $group->status;
        $this->group = $group;
    }

    public function openModal()
    {
        $this->reset('name', 'overview', 'description', 'status');
        $this->emit('openModal');

    }
    public function editData()
    {
        $data = $this->validate([
            'overview' => ['required'],
            'description' => ['required'],
            'status' => ['required'],
            'name' => ['required', 'min:2', 'max:44', Rule::unique('groups', 'name')->ignore($this->group['id'])]
        ]);
        $this->group->update($data);
        $this->emit('dataAdded', ['dataId' => 'item-id-'.$this->group->id]);
        $this->alert('success', __('Data updated successfully'));
        $this->reset('name', 'status', 'overview', 'description');
    }
    public function saveData()
    {
        $data = $this->validate([
            'overview' => ['required'],
            'description' => ['required'],
            'status' => ['required'],
            'name' => ['required', 'min:2', 'max:44', Rule::unique('groups', 'name')]
        ]);
        $data = Group::create($data);
        $this->reset('name', 'status', 'overview', 'description');
        $this->goToPage($this->getDataProperty()->lastPage());
        $this->emit('dataAdded', ['dataId' => 'item-id-'.$data->id]);
        $this->alert('success', __('Data updated successfully'));

    }
    public function orderByDirection($field)
    {
        $this->orderBy = $field;
        $this->orderDirection==='asc'? $this->orderDirection='desc': $this->orderDirection='asc';
    }

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->data->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        } else {
            $this->reset('selectedRows', 'selectPageRows');
        }
    }
    public function changeStatus(Group $group)
    {
        $group->status=='active'?$group->update(['status'=>'inactive']):$group->update(['status'=>'active']);
        $this->alert('success', __('Data updated successfully'));
    }
    public function deleteMultiple()
    {
        Group::whereIn('id', $this->selectedRows)->delete();
        $this->selectPageRows = false;
        $this->selectedRows = [];
        $this->alert('success', __('Data deleted successfully'));
    }
    public function deleteSingle(Group $group)
    {
        $group->delete();
        $this->alert('success', __('Data deleted successfully'));
    }
    public function getDataProperty()
    {
        return Group::with('products')->where($this->searchBy, 'like', '%'.$this->search.'%')->orderBy($this->orderBy, $this->orderDirection)->paginate($this->itemPerPage, ['id', 'name', 'status', 'created_at'])->withQueryString();
    }

    public function resetData()
    {
        $this->reset('name', 'status');
    }
    public function render()
    {
        $items = $this->data;
        return view('livewire.group-component', compact('items'));
    }
}
