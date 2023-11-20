document.addEventListener('livewire:navigated', () => {
    Livewire.dispatch('hide-preloader');
})
