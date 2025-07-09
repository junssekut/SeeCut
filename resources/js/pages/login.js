import gsap from "gsap";
import { MorphSVGPlugin } from "gsap/MorphSVGPlugin";

gsap.registerPlugin(MorphSVGPlugin);

const signupBtn = document.getElementById("signup-btn");
const signinBtn = document.getElementById("signin-btn");
const mainContainer = document.querySelector(".container");

signupBtn?.addEventListener("click", () => {
	mainContainer?.classList.toggle("change");
});

signinBtn?.addEventListener("click", () => {
	mainContainer?.classList.toggle("change");
});

window._activePasswordElements = null;

function togglePassword(inputId) {
	const input = document.getElementById(inputId);
	const openPath = document.getElementById("open");
	const closePath = document.getElementById("close");

	if (!input || !openPath || !closePath) return;

	const isPassword = input.type === "password";
	input.type = isPassword ? "text" : "password";

	const fromPath = isPassword ? closePath : openPath;
	const toPath = isPassword ? openPath : closePath;

	// Morph animation (SVG shape)
	gsap.to(fromPath, {
		duration: 0.5,
		morphSVG: toPath,
		ease: "power1.inOut",
	});

	// Optional: store current toggle state globally for click-outside handling
	if (isPassword) {
		window._activePasswordElements = { input };
	} else if (window._activePasswordElements?.input === input) {
		window._activePasswordElements = null;
	}
}

// Click outside = reset password field and icon
document.addEventListener("click", (event) => {
	const active = window._activePasswordElements;
	if (!active) return;

	const { input } = active;
	const openPath = document.getElementById("open");
	const closePath = document.getElementById("close");

	const isInside = input?.contains(event.target);

	if (!isInside && input.type === "text") {
		input.type = "password";

		// Morph back
		gsap.to(openPath, {
			duration: 0.5,
			morphSVG: closePath,
			ease: "power1.inOut",
		});

		window._activePasswordElements = null;
	}
});

// Hook up button
document.getElementById("passwordToggle")?.addEventListener("click", () => {
	togglePassword("passwordlogin");
});
