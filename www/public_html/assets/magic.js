(function () {
    let colorSwitcher = document.querySelector('#colorSwitcher')

    colorSwitcher.addEventListener('change', () => {
        localStorage.setItem("colorPreference", colorSwitcher.checked ? 1 : 0)
        document.getRootNode().children[0].classList.toggle("dark", !colorSwitcher.checked)
    })

    colorSwitcher.checked = (localStorage.getItem("colorPreference") === '1')
    colorSwitcher.dispatchEvent(new Event('change'))
})()
