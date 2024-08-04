<div x-data="{
    theme:@entangle('theme')
}" x-init="
    Alpine.store('theme', theme)
    $watch('theme', (value) => Alpine.store('theme', value))
" class="w-100 relative flex items-center cursor-pointer">
    @if($isDark)
        <x-icon name="sun" class="w-4 h-4 text-white absolute left-1 z-10" wire:click="$toggle('isDark')"></x-icon>
    @endif

    <x-toggle wire:model="isDark" name="toggle" xl wire:click="$toggle('isDark')"/>

    @unless($isDark)
        <x-icon name="moon" class="w-4 h-4 text-gray-400 absolute left-6 z-10" wire:click="$toggle('isDark')"></x-icon>
    @endunless
</div>
