<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Support\Renderable;
use Livewire\Component;
use function view;

class Curriculum extends Component
{
    public $model = \App\Models\Curriculum::class;
    public string $name, $description;
    public bool $openModal = false;

    public function render(): Renderable
    {
        return view('admin.curricula.index');
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->openModal = true;
    }
    public function closeModalPopover()
    {
        $this->openModal = false;
    }
    private function resetCreateForm()
    {
        $this->name = '';
        $this->description = '';
    }

    public function store()
    {
        $this->validate(['name' => 'required']);

        \App\Models\Curriculum::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);
        session()->flash('message', 'Curriculum added successfully.');
        $this->closeModalPopover();
        $this->resetCreateForm();
        return redirect()->route('curricula');
    }

    public function delete($id)
    {
        \App\Models\Curriculum::find($id)->delete();
        session()->flash('message', 'Curriculum deleted successfully.');
    }
}
