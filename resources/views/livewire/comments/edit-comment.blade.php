<?php

use Livewire\Volt\Component;
use App\Models\Comment;

new class extends Component {
    public Comment $comment;

    public $comment_content;

    public function mount(Comment $comment){
        $this->authorize('update', $comment);
        $this->fill($comment);
        $this->comment_content = $comment->comment_content;
    }

    public function saveComment(){
        $this->validate([
            'comment_content' => ['required', 'string', 'min:5'],
    ]);
    $this->comment->update([
        'comment_content' => $this->comment_content,
    ]);
    //figure out how to redirect from here
    redirect(route('post.view',$this->comment->post_id));
    }
}; ?>

<div>
    <form wire:submit='saveComment' class="space-y-4">
        <x-textarea wire:model='comment_content' label="Edit your comment" />
        <div class="pt-4 justify-between">
            <x-button light negative href="{{ route('post.view', $this->comment->post_id) }}">Cancel</x-button>
            <x-button right-icon="arrow-right" type="submit" spinner>Submit</x-button>
        </div>
    </form>
</div>
