/**
 * All The Things archive scripts
 */
window.addEventListener('load', () => {
	// start focus on quick links
	const quickSelect = document.querySelector('.all-the-things-control');
	if (quickSelect) {
		quickSelect.focus();
	}

	// lazy load iframes
	const iframes = document.querySelectorAll('iframe');
	let focusTracker = document.activeElement;
	// start loading the first iframe
	iframes[0]?.setAttribute('src', iframes[0].dataset.src);
	for (let i = 0; i < iframes.length; i++) {
		// on load of each iframe
		iframes[i].addEventListener('load', () => {
			iframes[i].classList.add('is-loaded');
			// if we have a 'next' iframe
			if (iframes[i+1]) {
				// if this isn't already loading
				if (!iframes[i+1].src) {
					// load this iframe
					iframes[i+1].setAttribute('src', iframes[i+1].dataset.src);
					if (i !== iframes.length - 2) {
						// prevent getting hung up on slow-loading iframes
						clearTimeout(iframes[i].timer);
						iframes[i+1].timer = setTimeout(() => {
							console.error('iframe ' + (i+1) + ' took too long to load: skipping for now', iframes[i+1])
							window.frames[i+1].stop()
							iframes[i+1].classList.add('is-delayed');
							if (iframes[i+2] && !iframes[i+2].src) {
								iframes[i+2].setAttribute('src', iframes[i+2].dataset.src);
							}
						}, 5000);
					// if this is the last iframe then try to reload any that we delayed due to slowness
					} else {
						for (let j = 0; j < iframes.length; j++) {
							clearTimeout(iframes[j].timer);
							if (iframes[j].classList.contains('is-delayed')) {
								console.error('attempting to reload slow iframe ' + j, iframes[j])
								iframes[j].setAttribute('src', iframes[j].dataset.src);
							}
						}
					}
				}
				// prevent focus from occurring within this iframe (e.g. wp's password protected field)
				if (document.activeElement.classList.contains('things-control')) {
					focusTracker = document.activeElement;
				} else {
					focusTracker.focus();
				}
			}
		});
	}
})