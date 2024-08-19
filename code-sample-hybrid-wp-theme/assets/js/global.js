/*!
 * Immediately Invoked Function Expression Boilerplate
 * (c) 2019 Chris Ferdinandi, MIT License, https://gomakethings.com
 */
;(function () {
	("use strict");

	// Element variables
	const menuToggle = document.querySelector(".menu-toggle");
	const navMenu = document.querySelector(
		'#header-bottom .nav-menu[role="navigation"]'
	);

	const elementExists = function (element) {
		if (typeof element != "undefined" && element != null) {
			return true;
		}
		return false;
	};

	// Event functions
	const toggleMenu = function (event) {
		if (!event.target.closest(".menu-toggle")) return;
		if (elementExists(navMenu)) {
			navMenu.classList.toggle("active");
		}
		menuToggle.classList.toggle("active");
	};

	const toggleSubMenu = function (event) {
		if (!event.target.closest(".submenu-expand")) return;
		event.target.closest(".submenu-expand").classList.toggle("expanded");
		event.preventDefault();
	};

	// Add functions to click event listener
	document.addEventListener("click", function (event) {
		toggleMenu(event);
		toggleSubMenu(event);
	});

	/* Modals
	--------------------------------------------- */
	// Get the modals
	let modals = document.querySelectorAll(".modal");
	for (let i = 0; i < modals.length; i++) {
		// Get this modal's ID.
		let modalID = modals[i].id;

		// Get the button that opens the modal - it's the ID of the modal with 'launch-' prepended
		let btn = document.getElementById("launch-" + modalID);

		// Get the element that closes the modal.
		let closer = modals[i].querySelector(".close");

		// When the user clicks on the button, open the modal
		if (btn) {
			btn.onclick = function () {
				modals[i].style.display = "block";
			};
		}

		// When the user clicks on <span> (x), close the modal
		if (closer) {
			closer.onclick = function () {
				modals[i].style.display = "none";
			};
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function (event) {
			if (event.target == modals[i]) {
				modals[i].style.display = "none";
			}
		};
	}

	/* Accordions
	--------------------------------------------- */
	const acc = document.getElementsByClassName("accordion");

	for (let i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function () {
			this.classList.toggle("active");

			if (this.closest(".kytg-references")) {
				if (this.classList.contains("active")) {
					this.textContent = "Close References";
				} else {
					this.textContent = "Show References";
				}
			}

			const panel = this.nextElementSibling;
			if (panel.style.maxHeight) {
				panel.style.maxHeight = null;
			} else {
				panel.style.maxHeight = panel.scrollHeight + "px";
			}
		});
	}

	/* Leaving Modal
	--------------------------------------------- */
	const modalLeaving = document.getElementById("modal-leaving");
	const continueLeaving = document.querySelector(
		".interstitial-button-leave"
	);
	const closeLeaving = document.querySelector(".interstitial-close-trigger");
	const newWindowLinks = document.querySelectorAll(
		'.site-container a[target="_blank"]'
	);
	let clickedLink;

	// Show the Leaving warning anywhere target="_blank" is clicked.
	for (let i = 0; i < newWindowLinks.length; i++) {
		newWindowLinks[i].addEventListener("click", function (e) {
			clickedLink = e.currentTarget.getAttribute("href");
			if (
				!clickedLink.includes("tgaware") &&
				!clickedLink.includes("knowyourtgs") &&
				!clickedLink.includes("ionispharma") &&
				!clickedLink.includes("vimeo.com")
			) {
				e.preventDefault();
				modalLeaving.style.display = "flex";
				continueLeaving.href = clickedLink;
				continueLeaving.setAttribute("target", "_blank");
			}
		});
	}

	if (continueLeaving) {
		continueLeaving.addEventListener("click", function (e) {
			modalLeaving.style.display = "none";
		});
	}
	if (closeLeaving) {
		closeLeaving.addEventListener("click", function (e) {
			modalLeaving.style.display = "none";
		});
	}

	// Glightbox, finding vimeo URLs and opening in lightbox.
	const vimeoLinks = document.querySelectorAll(
		'.site-container a[href^="https://vimeo.com/"]'
	);
	for (let i = 0; i < vimeoLinks.length; i++) {
		vimeoLinks[i].classList.add("glightbox");
	}
	GLightbox({
		selector: ".glightbox",
	});

	// Gravity Forms data attributes.
	const gForms = document.querySelectorAll(".gravity-form");
	for (let i = 0; i < gForms.length; i++) {
		// Set the form data attribute.
		let gFormClasses = gForms[i].className.split(" ");
		for (let j = 0; j < gFormClasses.length; j++) {
			if (gFormClasses[j].startsWith("form-")) {
				gForms[i].setAttribute("data-form_name", gFormClasses[j]);
				break;
			}
		}

		// Set the input and select data attributes.
		let gFormInputs = document.querySelectorAll(
			".gravity-form input, .gravity-form select"
		);
		for (let k = 0; k < gFormInputs.length; k++) {
			// Get the parent div's class and set this attribute.
			let gFormInputParent = gFormInputs[k].closest(".gfield");
			if (gFormInputParent) {
				let gFormInputParentClasses =
					gFormInputParent.className.split(" ");
				for (let l = 0; l < gFormInputParentClasses.length; l++) {
					if (gFormInputParentClasses[l].startsWith("input-")) {
						gFormInputs[k].setAttribute(
							"data-input_name",
							gFormInputParentClasses[l]
						);
						break;
					}
				}
			}
		}
	}

	// Search form modifications.
	const searchForm = document.querySelectorAll('form[role="search"]');
	for (let i = 0; i < searchForm.length; i++) {
		// For each form, change it's action to go to /search
		const formAction = searchForm[i].action;
		searchForm[i].action = formAction + "search";
	}

	const searchInputs = document.querySelectorAll('input[type="search"]');
	for (let i = 0; i < searchInputs.length; i++) {
		// For each input, change it's name to cs
		searchInputs[i].setAttribute("name", "cs");
	}

	// Extend background color of full width group block to left and right of screen.
	addFullWidthDiv();
	addPartialWidthDiv();
	setTimeout(() => {
		makeFullWidth();
		makePartialWidth();
	}, "100");

	window.addEventListener("resize", makeFullWidth);
	window.addEventListener("resize", makePartialWidth);

	function addFullWidthDiv() {
		let fullWidthGroupBlocks = document.querySelectorAll(
			".wp-block-group.alignfull"
		);

		if (fullWidthGroupBlocks) {
			for (let i = 0; i < fullWidthGroupBlocks.length; i++) {
				// Prepend a div we can style.
				let fakeBackgroundDiv = document.createElement("div");
				fakeBackgroundDiv.classList.add("full-width-background");
				fullWidthGroupBlocks[i].prepend(fakeBackgroundDiv);

				// Get its background color.
				let background = window.getComputedStyle(
					fullWidthGroupBlocks[i]
				).background;
				let backgroundColor = window.getComputedStyle(
					fullWidthGroupBlocks[i]
				).backgroundColor;

				fakeBackgroundDiv.style.background = background;
				fakeBackgroundDiv.style.backgroundColor = backgroundColor;
			}
		}
	}
	function addPartialWidthDiv() {
		let partialWidthGroupBlocks = document.querySelectorAll(
			".wp-block-group.alignpartial"
		);

		if (partialWidthGroupBlocks) {
			for (let i = 0; i < partialWidthGroupBlocks.length; i++) {
				// Prepend a div we can style.
				let fakeBackgroundDiv = document.createElement("div");
				fakeBackgroundDiv.classList.add("partial-width-background");
				partialWidthGroupBlocks[i].prepend(fakeBackgroundDiv);

				// Get its background color.
				let background = window.getComputedStyle(
					partialWidthGroupBlocks[i]
				).background;
				let backgroundColor = window.getComputedStyle(
					partialWidthGroupBlocks[i]
				).backgroundColor;

				// remove class for cta like on /nutrition-and-lifestyle/working-with-a-registered-dietician/
				partialWidthGroupBlocks[i].classList.remove(
					"has-white-to-orange-diagonal-gradient-background"
				);

				fakeBackgroundDiv.style.background = background;
				fakeBackgroundDiv.style.backgroundColor = backgroundColor;
			}
		}
	}
	function makeFullWidth() {
		let fullWidthGroupBlocks = document.querySelectorAll(
			".wp-block-group.alignfull"
		);

		if (fullWidthGroupBlocks) {
			for (let i = 0; i < fullWidthGroupBlocks.length; i++) {
				// Get its height.
				let blockHeight = fullWidthGroupBlocks[i].offsetHeight;

				// Get its top padding.
				let blockPaddingTop = window
					.getComputedStyle(fullWidthGroupBlocks[i])
					.paddingTop.replace("px", "");

				// Get its bottom padding.
				let blockPaddingBottom = window
					.getComputedStyle(fullWidthGroupBlocks[i])
					.paddingBottom.replace("px", "");

				let fakeBackgroundDiv = fullWidthGroupBlocks[i].querySelector(
					".full-width-background"
				);

				// Give div the height and top margin.
				fakeBackgroundDiv.style.height =
					blockHeight +
					parseInt(blockPaddingTop) +
					parseInt(blockPaddingBottom) +
					"px";
				fakeBackgroundDiv.style.marginTop =
					"-" + parseInt(blockPaddingTop) + "px";
			}
		}
	}
	function makePartialWidth() {
		let partialWidthGroupBlocks = document.querySelectorAll(
			".wp-block-group.alignpartial"
		);

		if (partialWidthGroupBlocks) {
			for (let i = 0; i < partialWidthGroupBlocks.length; i++) {
				// Get its height.
				let blockHeight = partialWidthGroupBlocks[i].offsetHeight;

				// Get its top padding.
				let blockPaddingTop = window
					.getComputedStyle(partialWidthGroupBlocks[i])
					.paddingTop.replace("px", "");

				// Get its bottom padding.
				let blockPaddingBottom = window
					.getComputedStyle(partialWidthGroupBlocks[i])
					.paddingBottom.replace("px", "");

				let fakeBackgroundDiv = partialWidthGroupBlocks[
					i
				].querySelector(".partial-width-background");

				// Give div the height and top margin.
				fakeBackgroundDiv.style.height =
					blockHeight +
					parseInt(blockPaddingTop) +
					parseInt(blockPaddingBottom) +
					"px";
				fakeBackgroundDiv.style.marginTop =
					"-" + parseInt(blockPaddingTop) + "px";
				partialWidthGroupBlocks[i].style.position = "relative";
				fakeBackgroundDiv.style.left = "-100%";
				fakeBackgroundDiv.style.right = "0";
			}
		}
	}

	/* Symptom tracker table.
	--------------------------------------------- */
	// Find the table
	let trackerTable = document.getElementById("kytgs-table-symptom-tracker");
	if (trackerTable) {
		// First row - make the first td have rowspan 2
		let firstRow = trackerTable.querySelector("tr:first-child");
		let firstRowFirstCol = trackerTable.querySelector("td:first-child");
		firstRowFirstCol.setAttribute("rowspan", "2");

		// First row - make the 2nd td have colspan 4
		let firstRowSecondCol = trackerTable.querySelector("td:nth-child(2)");
		firstRowSecondCol.setAttribute("colspan", "4");

		// First row - remove all empty tds
		let firstRowEmptyTds = firstRow.querySelectorAll("td");
		for (let i = 0; i < firstRowEmptyTds.length; i++) {
			if (firstRowEmptyTds[i].textContent.length === 0) {
				firstRowEmptyTds[i].remove();
			}
		}

		// Second row - remove empty td
		let secondRow = trackerTable.querySelector("tr:nth-child(2)");
		let secondRowEmptyTds = secondRow.querySelectorAll("td");
		for (let i = 0; i < secondRowEmptyTds.length; i++) {
			if (secondRowEmptyTds[i].textContent.length === 0) {
				secondRowEmptyTds[i].remove();
			}
		}
	}

	// Make tables full width.
	let fullWidthTables = document.querySelectorAll(".kytgs-table-simple");
	for (let i = 0; i < fullWidthTables.length; i++) {
		makeTableFullWidth(fullWidthTables[i]);
		window.addEventListener("resize", function () {
			makeTableFullWidth(fullWidthTables[i]);
		});
	}

	function makeTableFullWidth(table) {
		let windowWidth = window.innerWidth;
		let sidebar = document.querySelector(".sidebar-primary");
		let targetMargin;

		if (windowWidth <= 1024) {
			targetMargin = 0;
		} else if (windowWidth > 1600) {
			targetMargin =
				-1 *
				(16 +
					parseFloat(
						window.getComputedStyle(sidebar).width.replace("px", "")
					));
		} else if (windowWidth > 1024) {
			targetMargin =
				-1 *
				parseFloat(
					window.getComputedStyle(sidebar).width.replace("px", "")
				);
		}
		table.style.marginRight = targetMargin + "px";
	}

	// Back button.
	let backButton = document.getElementById("window-back");
	if (backButton) {
		backButton.onclick = function () {
			window.history.go(-1);
			return false;
		};
	}
	let backButton2 = document.getElementById("window-back-2");
	if (backButton2) {
		backButton2.onclick = function () {
			window.history.go(-2);
			return false;
		};
	}

	// Open PDF links in new window
	const pdfLinks = document.querySelectorAll('a[href$=".pdf"]');
	for (let i = 0; i < pdfLinks.length; i++) {
		pdfLinks[i].setAttribute("target", "_blank");
	}

	// Data layer push if order form page is loaded with errors
	const formErrors = document.querySelector(".gform_validation_errors");
	if (formErrors) {
		//console.log('datalayer push happening');
		dataLayer.push({ event: "form_error", page_url: window.location.href });
	}

	// Survey numbered questions
	const surveyQuestions = document.querySelectorAll(
		'form[action="/survey/"] .gfield:not(.subquestion) .gfield_label'
	);
	if (surveyQuestions) {
		surveyQuestions.forEach(function (element, i) {
			const html = `<span>${i + 1}. </span>`;
			element.insertAdjacentHTML("afterbegin", html);
		});
		const subQuestion_5_18 = document.querySelector(
			"#field_5_18 .gfield_label"
		);
		subQuestion_5_18.insertAdjacentHTML("afterbegin", "<span>2a. </span>");
		const subQuestion_5_19 = document.querySelector(
			"#field_5_19 .gfield_label"
		);
		subQuestion_5_19.insertAdjacentHTML("afterbegin", "<span>2b. </span>");
		const subQuestion_5_21 = document.querySelector(
			"#field_5_21 .gfield_label"
		);
		subQuestion_5_21.insertAdjacentHTML("afterbegin", "<span>3a. </span>");
	}

	// const surveySubQuestions = document.querySelectorAll(
	// 	'form[action="/survey/"] .gfield.subquestion .gfield_label'
	// );
	// if (surveySubQuestions) {
	// 	surveySubQuestions.forEach(function (element, i) {
	// 		const html = `<span>${i + 1}. </span>`;
	// 		element.insertAdjacentHTML("afterbegin", html);
	// 	});
	// }
})();
