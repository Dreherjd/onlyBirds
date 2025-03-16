<?php

use Livewire\Volt\Component;

new class extends Component {
    public $entry_title;
    public $entry_content;

    public function submit()
    {
        $validated = $this->validate([
            'entry_title' => ['required', 'string', 'min:5'],
            'entry_content' => ['required', 'string', 'min:20'],
        ]);
        auth()->user()->posts()->create([
            'entry_title' => $this->entry_title,
            'entry_content' => $this->entry_content,
        ]);
        redirect(route('dashboard'));
    }
}; ?>

<div>
    <form wire:submit='submit' class="space-y-4">
        <x-input wire:model='entry_title' label="Title" placeholder="What's up fellow bird nerds" />
        <x-textarea wire:model='entry_content' label="Content" />
        <div class="pt-4">
            <x-button light negative href="{{ route('dashboard') }}">Cancel</x-button>
            <x-button right-icon="arrow-right" type="submit" spinner>Submit</x-button>
        </div>
        <x-errors />
    </form>
</div>
