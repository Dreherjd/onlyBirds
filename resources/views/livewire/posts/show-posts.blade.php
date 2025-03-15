<?php

use Livewire\Volt\Component;
use App\Models\Post;

new class extends Component {
    public function with(): array
    {
        return [
            'posts' => Post::all(),
        ];
    }
}; ?>

<div class="space-y-2">
    <div class="grid grid-cols-2 gap-4 mt-6">
        @foreach ($posts as $post)
            <x-card wire:key="{{ $post->id }}" shadow="lg" rounded="lg">
                <x-slot name="title" class="italic !font-bold">
                    <a href="#">{{ $post->entry_title }}</a>
                </x-slot>
                {{ $post->entry_content }}
                <div class="flex items-end justify-between mt-4 space-y-2">
                    <p class="text-xs">{{ $post->user->name }}</p>
                </div>
                <br />
                <div>
                    <x-mini-button rounded icon="eye"></x-mini-button>
                    <x-mini-button rounded icon="trash"></x-mini-button>
                </div>
            </x-card>
        @endforeach
    </div>
</div>
