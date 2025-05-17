<div x-data="{
    darkMode: JSON.parse(localStorage.getItem('dcostsDarkMode')) ?? true,
    toggle() {this.darkMode = !this.darkMode}
}" x-init="$watch('darkMode', (value) => {
    Alpine.store('darkMode', value)
    localStorage.setItem('dcostsDarkMode', value)
})" class="w-100 relative flex items-center cursor-pointer">
    <template x-if="darkMode">
        <x-icon name="sun" class="w-4 h-4 text-white absolute left-1 z-10" @click="toggle()"></x-icon>
    </template>

    <x-toggle x-model="darkMode" name="toggle" xl />

    <template x-if="!darkMode">
        <x-icon name="moon" class="w-4 h-4 text-gray-400 absolute left-6 z-10" @click="toggle()"></x-icon>
    </template>
</div>
