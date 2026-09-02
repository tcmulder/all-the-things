/**
 * All The Things global behavior
 */
window.addEventListener("DOMContentLoaded", function () {
	// get the menu
	const allTheThingsMenu = document.getElementById("all-the-things")
	if (allTheThingsMenu) {
		// cache dom nodes and defaults
		const quickSelect = allTheThingsMenu.querySelector(
			".all-the-things-control",
		)

		// new-tab checkbox: restore from localStorage (default unchecked), persist on change
		const newTab = allTheThingsMenu.querySelector('input[type="checkbox"]')
		newTab.checked = localStorage.getItem("allTheThings.newTab") === "true"
		newTab.addEventListener("change", function () {
			localStorage.setItem("allTheThings.newTab", newTab.checked)
		})

		// prep to delay on keyboard input changes
		let isTyping = false
		// prep to open in new/same tab
		let anchorTarget = "_self"

		// focus on all the things menu with cmd+p and blur on escape
		document?.addEventListener("keydown", function (e) {
			if (
				(e.key === "p" &&
					e.metaKey &&
					document.activeElement === quickSelect) ||
				(e.key === "Escape" && document.activeElement === quickSelect)
			) {
				e.preventDefault()
				quickSelect.blur()
			} else if (e.key === "p" && e.metaKey) {
				e.preventDefault()
				quickSelect.focus()
			}
		})

		// on keydown in the select box
		quickSelect.addEventListener("keydown", function (e) {
			// if the key is "enter" then immediately follow the link
			if (e.key === "Enter") {
				if (quickSelect.value) {
					window.location = quickSelect.value
				}
			}
			// if the user is still typing/searching then delay navigation
			isTyping = true
			setTimeout(function () {
				isTyping = false
			}, 10)
		})

		// follow links on click (using isTyping to prevent navigation while still typing/searching)
		quickSelect.addEventListener("change", function () {
			if (!isTyping) {
				window.open(
					quickSelect.value,
					newTab.checked ? "_blank" : "_self",
				)
			}
		})
	}
})
