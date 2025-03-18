<?php

use Livewire\Volt\Component;
use App\Models\Post;
use App\Models\Comment;

new class extends Component {
    public Post $post;
    public function mount(Post $post)
    {
        $this->fill($post);
    }

    public function with(): array
    {
        return [
            'comments' => Comment::where('post_id', $this->post->id)->orderBy('created_at', 'desc')->get(),
        ];
    }
}; ?>

<div>
    <div class="mb-4">
        <p class="text-2xl">{{ $post->entry_title }}</p>
        <x-card shadow="md" rounded="2xl">
            {{ $post->entry_content }}
            <br /><br />
            {{ $post->like_count }} people liked this
            <br /><br />
            <p class="text-xs">{{ $post->user->name }} - {{ $post->created_at->diffForHumans() }}</p>
            <x-slot name="footer">
                <div class="flex justify-start space-x-1">
                    <x-button light primary icon="arrow-left" label="Back" href="{{ route('dashboard') }}" />
                    @if ($post->user->id === auth()->user()->id)
                        <x-button light negative label="Delete Post" />
                        <x-button href="{{ route('post.edit', $post) }}" primary label="Edit Post" />
                    @endif
                    <x-button href="{{ route('comment.create', $post) }}" primary label="Leave a Comment" />
                </div>
            </x-slot>
        </x-card>
    </div>
    @if ($comments->isNotEmpty())
        <p class="text-xl mx-20">Comments</p>
    @endif
    @foreach ($comments as $comment)
        <x-card class="mb-2 mx-20" rounded="2xl" shadow="2xl">
            <x-slot name="title">
                {{ $comment->user->name }} - {{ $comment->created_at->diffForHumans() }}
            </x-slot>
            {{ $comment->comment_content }}
            @if (auth()->user()->id === $comment->user_id)
                <x-slot name="footer">
                    <div class="flex justify-start space-x-1">
                        <x-button light negative label="Delete Comment" />
                        <x-button href="{{ route('comment.edit', $comment) }}" primary label="Edit Comment" />
                    </div>
                </x-slot>
            @endif
        </x-card>
    @endforeach


</div>
