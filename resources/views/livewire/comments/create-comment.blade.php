<?php

use Livewire\Volt\Component;
use App\Models\Post;

new class extends Component {
    public Post $post;
    public $comment_content;

    public function mount(Post $post)
    {
        $this->fill($post);
    }

    public function submit_comment()
    {
        $validated = $this->validate([
            'comment_content' => ['required', 'string', 'min:3'],
        ]);
        auth()
            ->user()
            ->comments()
            ->create([
                'comment_content' => $this->comment_content,
                'post_id' => $this->post->id,
            ]);
        redirect(route('post.view', $this->post->id));
    }
}; ?>

<div>
    <div>
        <p class="text-2xl">What do you want to say to {{ $post->user->name }}</p>
    </div>
    <form wire:submit='submit_comment'>
        <div class="flex mt-4">
            <x-textarea wire:model='comment_content' placeholder="That definitly was not a Cormorant" />
        </div>
        <div class="pt-4">
            <x-button light negative href="{{ route('post.view',$post->id) }}">Cancel</x-button>
            <x-button right-icon="arrow-right" type="submit" spinner>Submit</x-button>
        </div>
    </form>
</div>
