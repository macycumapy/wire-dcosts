const getDarkMode = () => JSON.parse(localStorage.getItem('dcostsDarkMode')) ?? true

const applyDarkMode = (value = getDarkMode()) => {
    document.documentElement.classList.toggle('dark', value)
    document.documentElement.style.colorScheme = value ? 'dark' : 'light'
}

applyDarkMode()

window.addEventListener('dcosts-dark-mode-updated', (event) => {
    applyDarkMode(event.detail)
})

document.addEventListener('livewire:navigated', () => {
    applyDarkMode()
    Livewire.dispatch('hide-preloader');
})
