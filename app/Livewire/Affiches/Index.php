<?php

namespace App\Livewire\Affiches;

use App\Models\Affiche;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Affiches Vitrine')]
class Index extends Component
{
    public function delete(Affiche $affiche): void
    {
        $affiche->delete();
        session()->flash('saved', 'Affiche supprimée.');
    }

    public function render(): View
    {
        return view('livewire.affiches.index', [
            'affiches' => Affiche::latest()->get(),
        ]);
    }
}
