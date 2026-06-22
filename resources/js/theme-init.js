(() => {
    let darkMode = true

    try {
        darkMode = JSON.parse(localStorage.getItem('dcostsDarkMode')) ?? true
    } catch {
        darkMode = true
    }

    document.documentElement.classList.toggle('dark', darkMode)
    document.documentElement.style.colorScheme = darkMode ? 'dark' : 'light'
})()
