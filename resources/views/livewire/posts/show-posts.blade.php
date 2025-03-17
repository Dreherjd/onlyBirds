<?php

use Livewire\Volt\Component;
use App\Models\Post;
use App\Models\Comment;

new class extends Component {
    public Post $post;
    public $like_count;

    protected $listeners = [
        'refresh-component' => '$refresh',
    ];

    public function delete($post_id)
    {
        $post = Post::where('id', $post_id)->first();
        $this->authorize('delete', $post);
        $post->delete();
    }

    public function with(): array
    {
        return [
            'posts' => Post::orderBy('created_at', 'desc')->get(),
        ];
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

<div class="space-y-2">
    <div class="grid grid-cols-1 gap-8 mx-60 mt-6">
        @foreach ($posts as $post)
            <x-card wire:key='{{ $post->id }}' title="{{ $post->entry_title }}" rounded="3xl" shadow="2xl">
                <x-slot name="slot">
                    <p>{{ Str::limit($post->entry_content, 400) }}</p>
                    <br />
                    <p class="text-xs">Written: {{ \Carbon\Carbon::parse($post->created_at)->format('M-d-Y') }} by
                        {{ $post->user->name }}</p>
                </x-slot>
                <x-slot name="footer" class="flex items-center justify-between">
                    <div>
                        <x-button wire:click="delete('{{ $post->id }}')" label="Delete" light negative />
                        <x-button href="{{ route('post.view', $post) }}" label="View" primary />
                    </div>
                    <div class="flex justify-between">
                        @if (Comment::getCount($post->id) == 1)
                            <p class="text-s mt-2 text-stone-500">{{ Comment::getCount($post->id) }} comment</p>
                        @else
                            <p class="text-s mt-2 text-stone-500">{{ Comment::getCount($post->id) }} comments</p>
                        @endif
                        &nbsp;&nbsp;&nbsp;
                        <x-button primary icon="hand-thumb-up" wire:click="likePost('{{ $post->id }}')"
                            label="{{ $post->like_count }}" />
                    </div>
                </x-slot>
            </x-card>
        @endforeach
    </div>
</div>
