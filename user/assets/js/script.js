document.addEventListener("DOMContentLoaded", function () {
	// Mengatur fitur dropdown profil saat di mode dekstop di menu navbar.
	const dropdwonnContent = document.querySelector(".avatar-dropdown .dropdown-content");
	const dropdown0ption = Array.from(document.querySelectorAll(".avatar-dropdown .dropdown-content a"));
	const dropbtn = document.querySelector("div.dropbtn");

	if (dropbtn) {
		dropbtn.addEventListener("click", (e) => {
			dropbtn.classList.toggle("active");
			e.stopPropagation();
			dropdwonnContent.classList.toggle("active");

			dropdown0ption.forEach((item) => {
				item.addEventListener("click", (e) => {
					dropdown0ption.forEach((value) => {
						if (value != item) {
							value.classList.remove("active");
						}
					});
					item.classList.add("active");
				});
			});
		});
	}


	
	// Mengatur fitur dropdown profil saat di mode mobile di menu navbar.
	const midDropdwonnContent = document.querySelector(".mid-avatar-dropdown .dropdown-content");
	const midDropdown0ption = Array.from(document.querySelectorAll(".mid-avatar-dropdown .dropdown-content a"));
	const midDropbtn = document.querySelector("div.mid-dropbtn");

	if (midDropbtn) {
		midDropbtn.addEventListener("click", (e) => {
			midDropbtn.classList.toggle("active");
			e.stopPropagation();
			midDropdwonnContent.classList.toggle("active");

			midDropdown0ption.forEach((item) => {
				item.addEventListener("click", (e) => {
					dropdown0ption.forEach((value) => {
						if (value != item) {
							value.classList.remove("active");
						}
					});
					item.classList.add("active");
				});
			});
		});
	}



	// Mengatur Fitur Dark Mode.
	const mode = document.querySelectorAll("div.mode")[0];
	const modeBtn = document.querySelector("button.dropbtn i:first-child");
	const dropdownWrapper = document.querySelectorAll(".dropdown-wrapper")[0];
	const lightMode = document.querySelector("span.light-mode");
	const darkMode = document.querySelector("span.dark-mode");
	const dropbtnMode = mode.querySelector("button.dropbtn");

	const midMode = document.querySelectorAll("div.mode")[1];
	const midModeBtn = document.querySelector("button.mid-mode-dropbtn i:first-child");
	const midDropdownWrapper = document.querySelectorAll('.dropdown-wrapper')[1];
	const midLightMode = document.getElementById("light-mode");
	const midDarkMode = document.getElementById("dark-mode");
	const midDropbtnMode = document.querySelector(".mid-mode-dropbtn");

	if (midMode) {
		midMode.addEventListener('click', () => {
			midDropdownWrapper.classList.toggle("active");
			midDropbtnMode.classList.toggle("active");
		});
	}

	if (mode) {
		mode.addEventListener("click", (e) => {
			dropdownWrapper.classList.toggle("active");
			dropbtnMode.classList.toggle("active");
			e.stopPropagation();
		});
	}

	function navbarSetMode(mode) {
		if (mode == "dark") {
			document.body.classList.add("active");
			lightMode.classList.remove("active");
			darkMode.classList.add("active");
			modeBtn.classList.replace("fa-sun", "fa-moon");
			localStorage.setItem("darkModeUser", "enabled");
		} else if (mode == "light") {
			document.body.classList.remove("active");
			darkMode.classList.remove("active");
			lightMode.classList.add("active");
			modeBtn.classList.replace("fa-moon", "fa-sun");
			localStorage.setItem("darkModeUser", "disabled");
		}
	}
	function MidbarSetMode(mode) {
		if (mode == "dark") {
			document.body.classList.add("active");
			midLightMode.classList.remove("active");
			midDarkMode.classList.add("active");
			midModeBtn.classList.replace("fa-sun", "fa-moon");
			localStorage.setItem("darkModeUser", "enabled");
		} else if (mode == "light") {
			document.body.classList.remove("active");
			midDarkMode.classList.remove("active");
			midLightMode.classList.add("active");
			midModeBtn.classList.replace("fa-moon", "fa-sun");
			localStorage.setItem("darkModeUser", "disabled");
		}
	}

	if (lightMode) { lightMode.addEventListener("click", () => navbarSetMode("light") ) }
	
	if (darkMode) { darkMode.addEventListener("click", () => navbarSetMode("dark") ) }

	if (midLightMode) { midLightMode.addEventListener("click", () => MidbarSetMode("light") ) }

	if (midDarkMode) { midDarkMode.addEventListener("click", () => MidbarSetMode("dark") ) }

	if (localStorage.getItem("darkModeUser") === "enabled") {
		if (lightMode && darkMode) navbarSetMode("dark");
		if (midLightMode && midDarkMode) MidbarSetMode("dark");
	} else {
		if (lightMode && darkMode) navbarSetMode("light");
		if (midLightMode && midDarkMode) MidbarSetMode("light");
	}



	// Mengatur bagian menu "Panduan Pengguna" di footer.
	const urlParams = new URLSearchParams(window.location.search);
	const scrollToQuestion = urlParams.get("goal");

	if (scrollToQuestion) {
		const questionSection = document.querySelector(".question");
		questionSection.scrollIntoView({ behavior: "smooth" });

		setTimeout(() => {
			const answers = Array.from(document.querySelectorAll("ul.answer"))[scrollToQuestion];
			const questionRow = Array.from(document.querySelectorAll("li.question-row"))[scrollToQuestion];
			if (questionRow && (scrollToQuestion == 1 || scrollToQuestion == 3 || scrollToQuestion == 4)) {
				questionRow.classList.add("active");
				const answerHeight = answers.scrollHeight + "px";
				answers.style.height = answerHeight;
				answers.style.margin = "4px 0";
			}
		}, 600);
	}



	// Mengatur fitur search di halaman koleksi buku.
	let inputs = document.getElementById("search");
	if (inputs) {
		inputs.addEventListener("input", () => {
			const cardContainer = document.querySelector("section.book-collection .card-container");
			const cards = Array.from(cardContainer.querySelectorAll(".card"));

			if (inputs.value == "") {
				cards.forEach((card) => {
					card.style.display = "";
					let noResult = document.querySelector(".no-result");
					if (noResult) {
						noResult.remove();
					}
				});
			} else {
				searchBooks();
			}
		});
	}
	function searchBooks() {
		let input = document.getElementById("search").value.toLowerCase();
		const cardContainer = document.querySelector("section.book-collection .card-container");
		const cards = Array.from(cardContainer.querySelectorAll(".card"));
		let found = false;

		let noResult = document.querySelector(".no-result");
		if (noResult) {
			noResult.remove();
		}

		cards.forEach((card) => {
			const h3 = card.querySelector("h3");
			let textH3 = h3.textContent || h3.innerText;

			if (textH3.toLowerCase().indexOf(input) > -1) {
				card.style.display = "";
				found = true;
			} else {
				card.style.display = "none";
			}
		});

		if (!found) {
			const noResultDiv = document.createElement("div");
			noResultDiv.classList.add("no-result");
			noResultDiv.textContent = "Ooops! Tidak ada hasil yang cocok untuk pencarianmu....";
			cardContainer.append(noResultDiv);
		}
	}



	// Mengatur menu Tabs pada halaman detail buku.
	function menuTabs(tabs, tabPanels) {
		tabs.forEach((tab) => {
			tab.addEventListener("click", function () {
				tabs.forEach((t) => {
					t.setAttribute("aria-selected", "false");
				});

				tabPanels.forEach((tp) => {
					tp.setAttribute("hidden", true);
				});

				this.setAttribute("aria-selected", "true");

				const panelId = this.getAttribute("aria-controls");
				document.getElementById(panelId).removeAttribute("hidden");
			});
		});
	}

	const tabsContent = Array.from(document.querySelectorAll('.details-content .tabs button[role="tab"]'));
	const tabPanelsContent = Array.from(document.querySelectorAll('.details-content div[role="tabpanel"]'));

	const tabsStory = Array.from(document.querySelectorAll('.details-story .tabs button[role="tab"]'));
	const tabPanelsStory = Array.from(document.querySelectorAll('.details-story div[role="tabpanel"]'));

	menuTabs(tabsContent, tabPanelsContent);
	menuTabs(tabsStory, tabPanelsStory);



	// Mengatur bagian "Pertanyaan yang sering ditanyakan".
	const question = Array.from(document.querySelectorAll("li.question-row"));
	const answers = Array.from(document.querySelectorAll("ul.answer"));

	question.forEach((item, index) => {
		item.addEventListener("click", function (e) {
			const questionContent = item.querySelector(".question-content");

			if (e.target == questionContent || e.target == questionContent.firstElementChild) {
				const answer = answers[index];

				question.forEach((otherItem) => {
					if (otherItem !== this) {
						otherItem.classList.remove("active");
						const otherAnswer = otherItem.querySelector("ul.answer");
						otherAnswer.style.height = "0";
						otherAnswer.style.margin = "0";
					}
				});

				this.classList.toggle("active");
				if (this.classList.contains("active")) {
					const answerHeight = answer.scrollHeight + "px";
					answer.style.height = answerHeight;
					answer.style.margin = "4px 0";
				} else {
					answer.style.height = "0";
					answer.style.margin = "0";
				}
			}
		});
	});


	
	// Mengatur bagian "Cerita" pada halaman detail_buku.
	const bab = Array.from(document.querySelectorAll("li.bab-row"));
	const isiBabs = Array.from(document.querySelectorAll("ul.fill"));

	bab.forEach((item, index) => {
		item.addEventListener("click", function (e) {
			const babContent = item.querySelector(".bab-content");

			if (e.target == babContent || e.target == babContent.firstElementChild) {
				const isiBab = isiBabs[index];

				bab.forEach((otherItem) => {
					if (otherItem !== this) {
						otherItem.classList.remove("active");
						const otherAnswer = otherItem.querySelector("ul.fill");
						otherAnswer.style.height = "0";
						otherAnswer.style.margin = "0";
					}
				});

				this.classList.toggle("active");
				if (this.classList.contains("active")) {
					const isiBabHeight = isiBab.scrollHeight + "px";
					isiBab.style.height = isiBabHeight;
					isiBab.style.margin = "4px 0";
				} else {
					isiBab.style.height = "0";
					isiBab.style.margin = "0";
				}
			}
		});
	});

	window.addEventListener("click", function (e) {
		// fitur dark mode.
		if (dropdownWrapper) {
			if (dropdownWrapper.classList.contains("active")) {
				dropdownWrapper.classList.remove("active");
				dropbtnMode.classList.remove("active");
			}
		}

		// fitur dropdown profil di menu navbar.
		if (dropdwonnContent) {
			if (dropdwonnContent.classList.contains("active")) {
				dropdwonnContent.classList.remove("active");
				dropbtn.classList.remove("active");
			}
		}

		if (midDropdwonnContent) {
			if (midDropdwonnContent.classList.contains("active")) {
				midDropdwonnContent.classList.remove("active");
				midDropbtn.classList.remove("active");
			}
		}

	});
});
