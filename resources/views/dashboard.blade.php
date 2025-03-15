<x-layouts.app :title="__('OnlyBirds')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <h1 class="text-4xl">What's up Bird Nerd</h1>

        </div>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <livewire:posts.show-posts />
        </div>
    </div>
</x-layouts.app>
