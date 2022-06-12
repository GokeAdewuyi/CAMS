<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Lecturer extends Component
{
    public bool $openModal = false;
    public string $name, $email, $pfn;

    public function render(): Renderable
    {
        return view('admin.lecturers.index');
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
        $this->email = '';
        $this->pfn = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'pfn' => 'sometimes|unique:users'
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'pfn' => $this->pfn,
            'password' => Hash::make($this->pfn ?? 'password')
        ]);
        session()->flash('message', 'Lecturer added successfully.');
        $this->closeModalPopover();
        $this->resetCreateForm();
        return redirect()->route('lecturers');
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'Lecturer deleted successfully.');
    }
}
