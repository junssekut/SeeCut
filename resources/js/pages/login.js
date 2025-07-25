import gsap from "gsap";
import { MorphSVGPlugin } from "gsap/MorphSVGPlugin";

// Register plugin safely
try {
	gsap.registerPlugin(MorphSVGPlugin);
} catch (error) {
	console.warn("MorphSVG plugin not available:", error);
}

// Global variable to track active password elements
window._activePasswordElements = null;

// Wait for DOM to be ready
if (document.readyState === "loading") {
	document.addEventListener("DOMContentLoaded", initializeLoginForm);
} else {
	initializeLoginForm();
}

function initializeLoginForm() {
	// Initialize password toggle first
	initializePasswordToggle();

	// Initialize view switching between login and register
	initializeViewToggle();
}

function initializeViewToggle() {
	const signupBtn = document.getElementById("signup-btn");
	const signinBtn = document.getElementById("signin-btn");
	const mainContainer = document.querySelector(".container");
	const signinIntro = document.querySelector(".signin-intro");
	const signupIntro = document.querySelector(".signup-intro");
	const signupForm = document.querySelector(".signup-form");
	const signinForm = document.querySelector(".signin-form");

	// "DAFTAR SEKARANG" button - switches to registration view
	if (signupBtn && mainContainer) {
		signupBtn.addEventListener("click", (e) => {
			e.preventDefault();
			e.stopPropagation();
			mainContainer.classList.add("change");

			// Ensure proper z-index for signup - form stays on right but becomes visible
			if (signinIntro && signupIntro && signupForm) {
				signinIntro.style.zIndex = "5";
				signupIntro.style.zIndex = "10";
				signupForm.style.zIndex = "25";
			}
		});
	}

	// "Masuk Sekarang" button - switches to login view
	if (signinBtn && mainContainer) {
		signinBtn.addEventListener("click", (e) => {
			e.preventDefault();
			e.stopPropagation();
			mainContainer.classList.remove("change");

			// Ensure proper z-index for signin - form moves to left, intro visible on right
			if (signinIntro && signupIntro && signupForm) {
				signinIntro.style.zIndex = "20";
				signupIntro.style.zIndex = "10";
				signupForm.style.zIndex = "1";
			}
		});
	}

	// Optional: Log for debugging
	if (signupBtn) console.log("Signup button found and event listener added");
	if (signinBtn) console.log("Signin button found and event listener added");
	if (mainContainer) console.log("Main container found");
}

function togglePassword(inputId) {
	const input = document.getElementById(inputId);
	const openPath = document.getElementById("open");
	const closePath = document.getElementById("close");

	// Validate all required elements exist
	if (!input) {
		console.warn(`Password input with id '${inputId}' not found`);
		return;
	}

	const isPassword = input.type === "password";
	input.type = isPassword ? "text" : "password";

	// Only animate if SVG elements exist and MorphSVG is available
	if (
		openPath &&
		closePath &&
		typeof gsap !== "undefined" &&
		gsap.plugins.morphSVG
	) {
		const fromPath = isPassword ? closePath : openPath;
		const toPath = isPassword ? openPath : closePath;

		try {
			// Morph animation (SVG shape)
			gsap.to(fromPath, {
				duration: 0.5,
				morphSVG: toPath,
				ease: "power1.inOut",
			});
		} catch (error) {
			console.warn("SVG animation failed:", error);
		}
	}

	// Track toggle state for click-outside handling
	if (isPassword) {
		window._activePasswordElements = { input, inputId };
	} else if (window._activePasswordElements?.input === input) {
		window._activePasswordElements = null;
	}
}

// Click outside handler - reset password field and icon
function setupClickOutsideHandler() {
	document.addEventListener("click", (event) => {
		const active = window._activePasswordElements;
		if (!active) return;

		const { input } = active;
		const openPath = document.getElementById("open");
		const closePath = document.getElementById("close");

		// Check if click was inside the input or its related elements
		const clickedElement = event.target;
		const isInsideInput = input?.contains(clickedElement);
		const isPasswordToggle =
			clickedElement?.id === "passwordToggle" ||
			clickedElement?.closest("#passwordToggle");

		if (!isInsideInput && !isPasswordToggle && input?.type === "text") {
			input.type = "password";

			// Morph back if elements exist and animation is available
			if (
				openPath &&
				closePath &&
				typeof gsap !== "undefined" &&
				gsap.plugins.morphSVG
			) {
				try {
					gsap.to(openPath, {
						duration: 0.5,
						morphSVG: closePath,
						ease: "power1.inOut",
					});
				} catch (error) {
					console.warn("SVG animation failed:", error);
				}
			}

			window._activePasswordElements = null;
		}
	});
}

// Initialize password toggle functionality
function initializePasswordToggle() {
	const passwordToggle = document.getElementById("passwordToggle");

	if (passwordToggle) {
		passwordToggle.addEventListener("click", (e) => {
			e.preventDefault();
			e.stopPropagation();
			togglePassword("passwordlogin");
		});
	}

	// Set up click outside handler
	setupClickOutsideHandler();
}
