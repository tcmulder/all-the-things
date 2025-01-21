/**
 * All The Things global behavior
 */
window.addEventListener('DOMContentLoaded', function () {
	// get the menu
	const allTheThingsMenu = document.getElementById('all-the-things');
	if (allTheThingsMenu) {
		// cache dom nodes
		const quickSelect = allTheThingsMenu.querySelector('.all-the-things-control');

		// prep to delay on keyboard input changes
		let isTyping = false;

		// focus on all the things menu with cmd+p
		document?.addEventListener('keydown', function (e) {
			if (e.key === 'p' && e.metaKey) {
				e.preventDefault();
				quickSelect.focus();
			}
		});

		// on keydown in the select box
		quickSelect.addEventListener('keydown', function (e) {
			// if the key is "enter" then immediately follow the link
			if (e.key === 'Enter') {
				if (quickSelect.value) {
					window.location = quickSelect.value;
				}
			}
			// if the user is still typing/searching then delay navigation
			isTyping = true;
			setTimeout(function () {
				isTyping = false;
			}, 10);
		});

		// follow links on click (using isTyping to prevent navigation while still typing/searching)
		quickSelect.addEventListener('change', function () {
			if (!isTyping) {
				window.location = quickSelect.value;
			}
		});
	}
});
