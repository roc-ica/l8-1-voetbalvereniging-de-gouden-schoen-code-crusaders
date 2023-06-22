const darkModeButton = document.getElementById("darkModeButton");
darkModeButton.addEventListener("click", toggleDarkMode);

document.addEventListener("load", function () {
	var DarkModeCookie = document.cookie;
	console.log(DarkModeCookie);
	console.log("DarkModeCookie");
});

document.getElementsByTagName("BODY")[0].onload = function () {
	var DarkModeCookie = getCookie("darkMode");
	console.log(DarkModeCookie);
	console.log("DarkModeCookie");
	console.log(document.cookie);
};

function getCookie(cname) {
	let name = cname + "=";
	let ca = document.cookie.split(";");
	for (let i = 0; i < ca.length; i++) {
		let c = ca[i];
		while (c.charAt(0) == " ") {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

function toggleDarkMode() {
	const body = document.body;
	body.classList.toggle("dark-mode");
	if (body.classList.contains("dark-mode")) {
		const d = new Date();
		d.setTime(d.getTime() + 365 * 24 * 60 * 60 * 1000);
		let expires = "expires=" + d.toUTCString();
		document.cookie = "DarkMode=true;" + expires + "; path=/";
	} else {
		const d = new Date();
		d.setTime(d.getTime() + 365 * 24 * 60 * 60 * 1000);
		let expires = "expires=" + d.toUTCString();
		document.cookie = "DarkMode=false;" + expires + "; path=/";
	}
}
