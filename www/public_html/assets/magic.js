(function () {
    let colorSwitcher = document.querySelector('#colorSwitcher')

    colorSwitcher.addEventListener('change', () => {
        localStorage.setItem("colorPreference", colorSwitcher.checked ? 1 : 0)
        document.getRootNode().children[0].classList.toggle("dark", !colorSwitcher.checked)
    })

    colorSwitcher.checked = (localStorage.getItem("colorPreference") === '1')
    colorSwitcher.dispatchEvent(new Event('change'))


})()

function toggleModal() {
    let modal = document.querySelector("#modal")
    modal.classList.toggle("hidden")
    modal.classList.toggle("opacity-0")
    modal.classList.toggle("opacity-100")
    document.body.classList.toggle("overflow-hidden")
}