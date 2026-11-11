/**
 * All The Things global behavior (pattern menu combobox)
 */
window.addEventListener( 'DOMContentLoaded', function () {
	const menu = document.querySelector( '.all-the-things-menu' );
	if ( ! menu ) {
		return;
	}

	const input = menu.querySelector( '.all-the-things-menu__input' );
	const list = menu.querySelector( '.all-the-things-menu__list' );
	const options = Array.from(
		list.querySelectorAll( '.all-the-things-menu__option' ),
	);

	let activeOption = null;

	/**
	 * Whether the listbox is open.
	 *
	 * @return {boolean}
	 */
	function isOpen() {
		return input.getAttribute( 'aria-expanded' ) === 'true';
	}

	/**
	 * Visible (unfiltered) options.
	 *
	 * @return {HTMLElement[]}
	 */
	function visibleOptions() {
		return options.filter( function ( option ) {
			return ! option.hasAttribute( 'hidden' );
		} );
	}

	/**
	 * Open a pattern URL.
	 *
	 * @param {HTMLElement} option Option element.
	 * @param {boolean}     newTab Open in a new tab.
	 */
	function openOption( option, newTab ) {
		const url = option && option.getAttribute( 'data-url' );
		if ( ! url ) {
			return;
		}
		if ( newTab ) {
			window.open( url, '_blank' );
		} else {
			window.location.href = url;
		}
	}

	/**
	 * Clear the active descendant highlight.
	 */
	function clearActive() {
		options.forEach( function ( option ) {
			option.setAttribute( 'aria-selected', 'false' );
			option.classList.remove( 'is-active' );
		} );
		input.setAttribute( 'aria-activedescendant', '' );
		activeOption = null;
	}

	/**
	 * Set the active option element.
	 *
	 * @param {HTMLElement|null} option Option to activate.
	 */
	function setActiveOption( option ) {
		clearActive();
		if ( ! option || option.hasAttribute( 'hidden' ) ) {
			return;
		}
		activeOption = option;
		option.setAttribute( 'aria-selected', 'true' );
		option.classList.add( 'is-active' );
		input.setAttribute( 'aria-activedescendant', option.id );
		option.scrollIntoView( { block: 'nearest' } );
	}

	/**
	 * Move the active highlight by delta within visible options.
	 *
	 * @param {number} delta Direction (+1 / -1).
	 */
	function moveActive( delta ) {
		const visible = visibleOptions();
		if ( ! visible.length ) {
			clearActive();
			return;
		}

		let index = visible.indexOf( activeOption );
		if ( index < 0 ) {
			index = delta > 0 ? 0 : visible.length - 1;
		} else {
			index = ( index + delta + visible.length ) % visible.length;
		}
		setActiveOption( visible[ index ] );
	}

	/**
	 * Open the listbox.
	 */
	function openList() {
		list.hidden = false;
		input.setAttribute( 'aria-expanded', 'true' );
	}

	/**
	 * Close the listbox.
	 */
	function closeList() {
		list.hidden = true;
		input.setAttribute( 'aria-expanded', 'false' );
		clearActive();
	}

	/**
	 * Filter options with case-insensitive substring match.
	 */
	function filterOptions() {
		const query = input.value.trim().toLowerCase();
		options.forEach( function ( option ) {
			const label = option.textContent.toLowerCase();
			const match = ! query || label.includes( query );
			option.toggleAttribute( 'hidden', ! match );
		} );

		const visible = visibleOptions();
		if ( ! visible.length ) {
			clearActive();
			return;
		}

		if ( query ) {
			setActiveOption( visible[ 0 ] );
		} else if ( activeOption && ! activeOption.hasAttribute( 'hidden' ) ) {
			setActiveOption( activeOption );
		} else {
			clearActive();
		}
	}

	input.addEventListener( 'focus', function () {
		openList();
		filterOptions();
	} );

	input.addEventListener( 'input', function () {
		openList();
		filterOptions();
	} );

	input.addEventListener( 'keydown', function ( e ) {
		const newTab = e.metaKey || e.ctrlKey;

		if ( e.key === 'ArrowDown' ) {
			e.preventDefault();
			openList();
			moveActive( 1 );
			return;
		}

		if ( e.key === 'ArrowUp' ) {
			e.preventDefault();
			openList();
			moveActive( -1 );
			return;
		}

		if ( e.key === 'Enter' ) {
			if ( activeOption && ! activeOption.hasAttribute( 'hidden' ) ) {
				e.preventDefault();
				openOption( activeOption, newTab );
			}
			return;
		}

		if ( e.key === 'Escape' ) {
			e.preventDefault();
			if ( isOpen() ) {
				closeList();
			} else if ( input.value ) {
				input.value = '';
				filterOptions();
			} else {
				input.blur();
			}
		}
	} );

	list.addEventListener( 'click', function ( e ) {
		const option = e.target.closest( '.all-the-things-menu__option' );
		if ( ! option || option.hasAttribute( 'hidden' ) ) {
			return;
		}
		e.preventDefault();
		openOption( option, e.metaKey || e.ctrlKey );
	} );

	document.addEventListener( 'mousedown', function ( e ) {
		if ( ! menu.contains( e.target ) ) {
			closeList();
		}
	} );

	// Focus the menu with cmd/ctrl+p; blur when already focused.
	document.addEventListener( 'keydown', function ( e ) {
		if ( e.key !== 'p' || ( ! e.metaKey && ! e.ctrlKey ) ) {
			return;
		}
		e.preventDefault();
		if ( document.activeElement === input ) {
			input.blur();
			closeList();
		} else {
			input.focus();
		}
	} );
} );
