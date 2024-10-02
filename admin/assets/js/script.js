document.addEventListener("DOMContentLoaded", function () {

	// Handle hidden atau tidaknya suatu sidebar.
	const toggleIcon = document.querySelector(".navbar li span i");
	const sidebar = document.querySelector("nav.sidebar");
	const navbar = document.querySelector(".navbar");
	const mainContainer = document.querySelector(".main-container");
	const infoDenda = document.querySelector(".info-denda");
	const titleNav = document.getElementById('title-nav');

	function toggleSidebar() {
		if (toggleIcon.classList.contains("fa-xmark")) {
			toggleIcon.classList.remove("fa-xmark");
			toggleIcon.classList.add("fa-bars");
			sidebar.classList.add("active");
			navbar.classList.add("active");
			mainContainer.classList.add("active");

			if (window.innerWidth < 768) titleNav.style.display = 'block';
			if (infoDenda) infoDenda.classList.add("active");

			localStorage.setItem("sidebarStatus", "active");

			sidebar.style.transition = "all 0.3s ease-in-out";
			mainContainer.style.transition = "all 0.3s ease-in-out";
			navbar.style.transition = "all 0.3s ease-in-out";
		} else {
			toggleIcon.classList.add("fa-xmark");
			toggleIcon.classList.remove("fa-bars");
			sidebar.classList.remove("active");
			navbar.classList.remove("active");
			mainContainer.classList.remove("active");
			
			if (window.innerWidth < 768) titleNav.style.display = 'none';
			if (infoDenda) infoDenda.classList.remove("active");

			localStorage.setItem("sidebarStatus", "unactive");

			sidebar.style.transition = "all 0.3s ease-in-out";
			mainContainer.style.transition = "all 0.3s ease-in-out";
			navbar.style.transition = "all 0.3s ease-in-out";
		}
	}

	function initializeSidebar() {
		const status = localStorage.getItem("sidebarStatus");

		if (status == "active") {
			if (toggleIcon) {
				toggleIcon.classList.remove("fa-xmark");
				toggleIcon.classList.add("fa-bars");
			}
			sidebar.classList.add("active");
			navbar.classList.add("active");
			mainContainer.classList.add("active");
			if (window.innerWidth < 768) titleNav.style.display = 'block';

			sidebar.style.transition = "0s";
			mainContainer.style.transition = "0s";
			navbar.style.transition = "0s";
		} else if (status == "unactive") {
			if (toggleIcon) {
				toggleIcon.classList.add("fa-xmark");
				toggleIcon.classList.remove("fa-bars");
			}
			sidebar.classList.remove("active");
			navbar.classList.remove("active");
			mainContainer.classList.remove("active");
			if (window.innerWidth < 768) titleNav.style.display = 'none';

			sidebar.style.transition = "0s";
			mainContainer.style.transition = "0s";
			navbar.style.transition = "0s";
		}
	}

	initializeSidebar();

	if (toggleIcon) {
		toggleIcon.addEventListener("click", () => {
			toggleSidebar();
		});
	}



	// Handle dropdown di sidebar
	const navLink = Array.from(document.querySelectorAll(".nav-link"));
	navLink.forEach((element) => {
		element.addEventListener("click", function (e) {
			e.preventDefault();

			const li = this.parentElement;
			const submenu = this.nextElementSibling;
			const allSubMenu = Array.from(document.querySelectorAll("li ul"));

			allSubMenu.forEach((sub) => {
				if (sub !== submenu) {
					sub.parentElement.classList.remove("active");
					sub.style.height = "0";
				}
			});

			if (li.classList.contains("active")) {
				li.classList.remove("active");
				submenu.style.height = "0";
			} else {
				li.classList.add("active");
				submenu.style.height = "5.2rem";
			}
		});

		if (element.classList.contains("active")) {
			element.nextElementSibling.style.height = "5.2rem";
		}
	});



	// Mengatur Fitur Dark Mode.
	const mode = document.querySelector("li.mode");
	const modeBtn = document.querySelector("button.dropbtn i:first-child");
	const dropdownWrapper = mode.querySelector(".dropdown-wrapper");
	const lightMode = dropdownWrapper.querySelector("span.light-mode");
	const darkMode = dropdownWrapper.querySelector("span.dark-mode");

	mode.addEventListener("click", (e) => {
		dropdownWrapper.classList.toggle("active");
		e.stopPropagation();
	});

	function setMode(mode) {
		if (mode == "dark") {
			document.body.classList.add("active");
			lightMode.classList.remove("active");
			darkMode.classList.add("active");
			modeBtn.classList.replace("fa-sun", "fa-moon");
			localStorage.setItem("darkModeAdmin", "enabled");
		} else if (mode == "light") {
			document.body.classList.remove("active");
			darkMode.classList.remove("active");
			lightMode.classList.add("active");
			modeBtn.classList.replace("fa-moon", "fa-sun");
			localStorage.setItem("darkModeAdmin", "disabled");
		}
	}

	lightMode.addEventListener("click", function () {
		setMode("light");
	});
	darkMode.addEventListener("click", function () {
		setMode("dark");
	});

	if (localStorage.getItem("darkModeAdmin") === "enabled") {
		setMode("dark");
	} else {
		setMode("light");
	}



	// Mengatur fitur search pada tabel.
	const tableBody = document.querySelector("table tbody");
	let inputs = document.getElementById("search");
	if (inputs) {
		inputs.addEventListener('input', () => {
			let table = document.querySelector(".table");
			let tr = Array.from(table.querySelectorAll("tr"));

			if (inputs.value == '') {
				tr.forEach(row => {
					row.style.display = '';
					let noResultRow = document.querySelector(".no-result-row");
					if (noResultRow) {
						noResultRow.remove();
					}
				});
			} else {
				searchBooks();
			}
		});
	}

	function searchBooks() {
		let input = document.getElementById("search").value.toLowerCase();
		let table = document.querySelector(".table");
		let tr = table.getElementsByTagName("tr");
		let found = false;

		let noResultRow = document.querySelector(".no-result-row");
		if (noResultRow) {
			noResultRow.remove();
		}

		for (i = 1; i < tr.length; i++) {
			let td = tr[i].getElementsByTagName("td");
			let match = false;

			for (j = 0; j < td.length; j++) {
				if (td[j]) {
					let textValue = td[j].textContent || td[j].innerText;
					if (textValue.toLowerCase().indexOf(input) > -1) {
						match = true;
						break;
					}
				}
			}
			if (match) {
				tr[i].style.display = "";
				found = true;
			} else {
				tr[i].style.display = "none";
			}
		}

		if (!found) {
			const noResultRow = document.createElement("tr");
			noResultRow.classList.add("no-result-row");
			const td = document.createElement("td");
			td.colSpan = 7;
			td.style.textAlign = "center";
			td.style.backgroundColor = "rgba(123, 0, 254, 0.15)";
			td.style.padding = "1rem 0";

			if (window.innerWidth < 768) {
				td.textContent = "Tidak ada hasil yang ditemukan...";
			} else {
				td.textContent = "Oops! Tidak ada hasil yang cocok untuk pencarianmu.";
			}
			noResultRow.appendChild(td);
			tableBody.appendChild(noResultRow);
		}
	}



	// Mengatur tombol titik 3 di pojok kanan tabel.
	const btnHapus = document.querySelector("div.btn button.hapus");
	if (btnHapus) {
		btnHapus.addEventListener("click", (e) => {
			e.stopPropagation();
			btnHapus.nextElementSibling.lastElementChild.classList.toggle("active");
		});
	}



	// Mengatur dropdown di kolom aksi tabel.
	function aksiTable() {
		const dropdowns = document.querySelectorAll(".dropdown");

		dropdowns.forEach((dropdown) => {
			const button = dropdown.querySelector(".dropbtn");
			const content = dropdown.querySelector(".dropdown-content");

			button.addEventListener("click", function (e) {
				dropdowns.forEach((d) => {
					if (d !== dropdown) {
						d.querySelector(".dropdown-content").classList.remove("show");
					}
				});
				content.classList.toggle("show");
				e.stopPropagation();
			});
		});
		window.addEventListener("click", function () {
			const btnHapus = document.querySelector("div.btn button.hapus");
			if (btnHapus) {
				if (btnHapus.nextElementSibling.lastElementChild.classList.contains("active")) {
					btnHapus.nextElementSibling.lastElementChild.classList.remove("active");
				}
			}
			dropdowns.forEach((dropdown) => {
				dropdown.querySelector(".dropdown-content").classList.remove("show");
			});

			if (dropdownWrapper.classList.contains('active')) {
				dropdownWrapper.classList.remove("active");
			}
		});
	}
	aksiTable();
});
