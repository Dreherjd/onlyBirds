<?php

use Livewire\Volt\Component;
use App\Models\Post;

new class extends Component {
    public Post $post;

    public function mount(Post $post){
        $this->fill($post);
    }
}; ?>

<div>
    <p class="text-2xl">{{ $post->entry_title }}</p>
    <x-card shadow="md" rounded="2xl">
        {{ $post->entry_content }}
        <br /><br />
        <p class="text-xs">Written: {{ \Carbon\Carbon::parse($post->created_at)->format('M-d-Y') }} by {{ $post->user->name }}</p>
        <x-slot name="footer">
            <div class="flex justify-start space-x-1">
                <x-button light primary icon="arrow-left" label="Back" href="{{ route('dashboard') }}" />
                <x-button light negative label="Delete"/>
                <x-button href="{{ route('post.edit', $post) }}" primary label="Edit"/>
                <x-button href="{{ route('comment.create', $post) }}" primary label="Comment" />
            </div>
        </x-slot>
    </x-card>
    
</div>
