(() => {
    const darkMode = JSON.parse(localStorage.getItem('dcostsDarkMode')) ?? true

    document.documentElement.classList.toggle('dark', darkMode)
    document.documentElement.style.colorScheme = darkMode ? 'dark' : 'light'
})()
