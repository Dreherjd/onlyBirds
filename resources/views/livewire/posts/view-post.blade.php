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

    protected $listeners = [
        'refresh-component' => '$refresh',
    ];

    public function deletePost($post_id)
    {
        $post = Post::where('id', $post_id)->first();
        $this->authorize('delete', $post);
        $post->delete();
        redirect(route('dashboard'));
    }

    public function deleteComment($comment_id)
    {
        $comment = Comment::where('id', $comment_id)->first();
        $this->authorize('delete', $comment);
        $comment->delete();
    }

    public function likePost($post_id)
    {
        $post = Post::where('id', $post_id)->first();
        $like_count = $post->like_count;
        $like_count++;
        $post->like_count = $like_count;
        $post->save();
        $this->dispatch('refresh-component');
    }
}; ?>

<div>
    <div class="mb-4">
        <p class="text-2xl">{{ $post->entry_title }}</p>
        <x-card shadow="md" rounded="2xl">
            <div style="white-space:pre-line;">
                {{ $post->entry_content }}
            </div>
            <br /><br />
            <p class="text-xs">{{ $post->user->name }} - {{ $post->created_at->diffForHumans() }}</p>
            <x-slot name="footer" class="flex items-center justify-between">
                <div class="flex justify-start space-x-1">
                    <x-button light primary icon="arrow-left" label="Back" href="{{ route('dashboard') }}" />
                    @if ($post->user->id === auth()->user()->id)
                        <x-button wire:click="deletePost('{{ $post->id }}')" light negative label="Delete Post" />
                        <x-button href="{{ route('post.edit', $post) }}" primary label="Edit Post" />
                    @endif
                    <x-button href="{{ route('comment.create', $post) }}" primary label="Leave a Comment" />
                </div>
                <div class="flex justify-end">
                    <x-button primary icon="hand-thumb-up" wire:click="likePost('{{ $post->id }}')"
                        label="{{ $post->like_count }}" />
                </div>
            </x-slot>
        </x-card>
    </div>
    @if ($comments->isNotEmpty())
        <p class="text-xl mx-20">Comments</p>
    @endif
    @foreach ($comments as $comment)
        <x-card class="mb-2 mx-20" rounded="2xl" shadow="2xl" wire:key='{{ $comment->id }}'>
            <x-slot name="title">
                {{ $comment->user->name }} - {{ $comment->created_at->diffForHumans() }}
            </x-slot>
            {{ $comment->comment_content }}
            @if (auth()->user()->id === $comment->user_id)
                <x-slot name="footer">
                    <div class="flex justify-start space-x-1">
                        <x-button wire:click="deleteComment('{{ $comment->id }}')" light negative
                            label="Delete Comment" />
                        <x-button href="{{ route('comment.edit', $comment) }}" primary label="Edit Comment" />
                    </div>
                </x-slot>
            @endif
        </x-card>
    @endforeach


</div>
