<?php

use Livewire\Volt\Component;
use App\Models\Post;

new class extends Component {
    public Post $post;

    public $entry_title;
    public $entry_content;

    public function mount(Post $post){
        $this->authorize('update', $post);
        $this->fill($post);
        $this->entry_title = $post->entry_title;
        $this->entry_content = $post->entry_content;
    }

    public function savePost(){
        $this->validate([
            'entry_title' => ['required', 'string', 'min:5'],
            'entry_content' => ['required', 'string', 'min:20'],
        ]);
        $this->post->update([
            'entry_title' => $this->entry_title,
            'entry_content' => $this->entry_content,
        ]);
        redirect(route('post.view', $this->post));
    }

}; ?>

<div>
    <div>
        <form wire:submit='savePost' class="space-y-4">
            <x-input wire:model='entry_title' label="Title" placeholder="What's up fellow bird nerds" />
            <x-textarea wire:model='entry_content' label="Content" />
            <div class="pt-4 justify-between">
                <x-button light negative href="{{ route('dashboard') }}">Cancel</x-button>
                <x-button right-icon="arrow-right" type="submit" spinner>Submit</x-button>
            </div>
            <x-errors />
        </form>
    </div>
</div>
