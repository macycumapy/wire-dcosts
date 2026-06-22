const getDarkMode = () => JSON.parse(localStorage.getItem('dcostsDarkMode')) ?? true

const applyDarkMode = (value = getDarkMode()) => {
    document.documentElement.classList.toggle('dark', value)
    document.documentElement.style.colorScheme = value ? 'dark' : 'light'
}

export {
    applyDarkMode,
}
