function cloneDescriptions(target, form_id) {
	let fieldsets = document.querySelectorAll('#kytg-quiz .gfield');

	for (let i = 0; i < fieldsets.length; i++) {
		console.log(fieldsets[i]);
		let page = fieldsets[i].closest('.gform_page');
		let pageID = page.getAttribute('id');
		let pageNumber = pageID.replace("gform_page_" + form_id + "_", "");

		let fieldsetID = fieldsets[i].getAttribute("id");
		let descriptionID = fieldsetID.replace("field", "gfield_description");

		descriptionClone = false;

		if (document.getElementById(descriptionID)) {

			descriptionClone = document.getElementById(descriptionID).cloneNode(true);
			target.append(descriptionClone);
			descriptionClone.id = descriptionID + '_page-' + pageNumber + '-clone';
			descriptionCloneID = descriptionClone.id;
			document.getElementById(descriptionCloneID).style.display = "none";
		}
	}
}
function setAdditionalText() {
	// Set some additional text, add it to all gfield_descriptions areas just once on load.
	let additionalText = '<p class="question-additional" style="display: none; margin-top: 16px; font-size: 16px; font-style: italic;">Even if it\'s not FCS, you may have concerns about your triglyceride levels or symptoms you\'re experiencing. Talk to your doctor to understand more about your triglyceride levels.</p>';
	let gfieldDescriptions = document.querySelectorAll('#kytg-quiz .gfield_description');

	for (let i = 0; i < gfieldDescriptions.length; i++) {
		gfieldDescriptions[i].innerHTML += additionalText;
	}
}
function showDescription(selectedInput, page) {
	// Get the input ID
	let selectedInputID = selectedInput.closest('.gfield_radio').getAttribute('id');


	// Find the fieldset ID
	let fieldsetID = selectedInputID.replace("input", "field");

	// Find the description ID, and its clone too.
	let descriptionID = selectedInputID.replace("input", "gfield_description");
	let descriptionCloneID = descriptionID + '_page-' + page + '-clone';

	// Show the descriptions.
	document.querySelector('#kytg-circle').style.backgroundImage = "radial-gradient(circle at center right,#e6e9fb,#9e7feb 80%)";
	description = document.getElementById(descriptionID);
	descriptionClone = document.getElementById(descriptionCloneID);
	description.style.display = "block";
	descriptionClone.style.display = "block";

	// Show the additional text if answer isn't Yes.
	let selectedInputValue = selectedInput.value;
	if ("No" === selectedInputValue || "I don\'t know" === selectedInputValue) {
		description.querySelector('.question-additional').style.display = "block";
		descriptionClone.querySelector('.question-additional').style.display = "block";
	} else {
		description.querySelector('.question-additional').style.display = "none";
		descriptionClone.querySelector('.question-additional').style.display = "none";
	}
}

jQuery(document).on('gform_post_render', function(event, form_id, current_page){
	if (4 == form_id) {
		// Let's add a body class to help us.
		document.body.classList.remove('quiz-page-' + (current_page * 1 - 1));
		document.body.classList.remove('quiz-page-' + (current_page * 1 + 1));
		document.body.classList.add('quiz-page-' + current_page);

		// Move the steps to the right.
		let gfSteps = document.getElementById("gf_page_steps_" + form_id);
		let target = document.getElementById("question-tip");
		target.prepend(gfSteps);

		let pageIndex = '<div class="page-index">Question <span id="current-page-number"></span> of 5</div>';
		if (!document.getElementById('current-page-number')) {
			target.innerHTML += pageIndex;
		}
		document.getElementById('current-page-number').textContent = current_page;


		// Put additional text in the descriptions.
		setAdditionalText();

		// Clone the descriptions to the tip area, just once - these stick on page changes.
		if (1 == current_page) {
			cloneDescriptions(target, form_id);
		}

		// Show descriptions for selected inputs on load and on change.
		let inputs = document.querySelectorAll('#kytg-quiz #gform_page_' + form_id + '_' + current_page + ' .gfield-choice-input');
		let selectedInputValue = false;
		for (let i = 0; i < inputs.length; i++) {
			if (inputs[i].checked) {
				// If anything is checked, show the associated tip.
				showDescription(inputs[i], current_page);
			}
			inputs[i].addEventListener("change", (event) => {
				// If anything changes, show the associated tip.
				showDescription(inputs[i], current_page);
			});
		}

		if (6 == current_page) {
			// Tip area is darker purple always on final page.
			document.querySelector('#kytg-circle').style.backgroundImage = "radial-gradient(circle at center right,#e6e9fb,#9e7feb 80%)";

			// Find and move the .survey-callout to the target area.
			let surveyCallout = document.querySelector('.survey-callout');
			if (!target.querySelector('.survey-callout')) {
				target.append(surveyCallout);
			}
		}
	}
});

// On page changes, clean up and reset some things.
jQuery(document).on('gform_page_loaded', function(event, form_id, current_page){
	if (4 == form_id) {
		// Get rid of the last set of steps otherwise they duplicate.
		let expiredGFSteps = document.querySelector('#question-tip #gf_page_steps_' + form_id);
		if (expiredGFSteps) {
			expiredGFSteps.remove();
		}

		// Hide descriptions again.
		let gfieldDescriptions = document.querySelectorAll('#kytg-quiz .gfield_description');
		for (let i = 0; i < gfieldDescriptions.length; i++) {
			gfieldDescriptions[i].style.display = "none";
		}

		// Reset sidebar color.
		document.querySelector('#kytg-circle').style.backgroundImage = "radial-gradient(circle at center right,#e6e9fb,#d4cff7 80%)";
	}
});