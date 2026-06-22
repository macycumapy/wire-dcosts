import {applyDarkMode} from "./theme"

window.addEventListener('dcosts-dark-mode-updated', (event) => {
    applyDarkMode(event.detail)
})

document.addEventListener('livewire:navigated', () => {
    applyDarkMode()
    Livewire.dispatch('hide-preloader');
})
