const getDarkMode = () => {
    try {
        return JSON.parse(localStorage.getItem('dcostsDarkMode')) ?? true
    } catch {
        return true
    }
}

const applyDarkMode = (value = getDarkMode()) => {
    document.documentElement.classList.toggle('dark', value)
    document.documentElement.style.colorScheme = value ? 'dark' : 'light'
}

export {
    applyDarkMode,
}
