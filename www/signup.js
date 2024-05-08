// Importing functions from functions.js
import { displayErrorMessage } from "./functions.js";
import { showImageName } from "./functions.js";

/**
 * Validates the form inputs and displays error messages if necessary.
 * @returns {boolean} True if the form inputs are valid, false otherwise.
 */
function checkForm() {
  // Get form input elements
  const usernameInput = document.getElementById("username_input");
  const emailInput = document.getElementById("email_input");
  const passwordInput = document.getElementById("password_input");
  const confirmPasswordInput = document.getElementById(
    "confirm_password_input"
  );
  const fileInput = document.getElementById("file_input");

  // Remove existing error messages
  const errorMessages = document.querySelectorAll(".error");
  errorMessages.forEach((errorMessage) => {
    errorMessage.remove();
  });

  // Validate username input
  if (usernameInput.value.trim() === "") {
    displayErrorMessage("Please enter your username", usernameInput);
    return false;
  } else {
    const usernameFormat = /^[a-zA-Z0-9]+$/;
    if (!usernameFormat.test(usernameInput.value.trim())) {
      displayErrorMessage("Please enter a valid username", usernameInput);
      return false;
    }
  }

  // Validate email input
  if (emailInput.value.trim() === "") {
    displayErrorMessage("Please enter your email", emailInput);
    return false;
  } else {
    const emailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailFormat.test(emailInput.value.trim())) {
      displayErrorMessage("Please enter a valid email", emailInput);
      return false;
    }
  }

  // Validate password input
  if (passwordInput.value.trim() === "") {
    displayErrorMessage("Please enter your password", passwordInput);
    return false;
  }

  // Validate confirm password input
  if (confirmPasswordInput.value.trim() === "") {
    displayErrorMessage("Please confirm your password", confirmPasswordInput);
    return false;
  }

  // Check if passwords match
  if (passwordInput.value.trim() !== confirmPasswordInput.value.trim()) {
    displayErrorMessage("Passwords do not match", confirmPasswordInput);
    return false;
  }

  // Validate file input
  if (fileInput.value.trim() === "") {
    displayErrorMessage("Please upload an image", fileInput);
    return false;
  } else {
    showImageName(fileInput.files[0].name, fileInput);
    var allowedFiles = [".jpeg", ".png", ".jpg"];
    var regex = new RegExp(
      "([a-zA-Z0-9s_\\.-:])+(" + allowedFiles.join("|") + ")$"
    );
    if (!regex.test(fileInput.value.toLowerCase())) {
      displayErrorMessage("Please upload a valid image file", fileInput);
      return false;
    } else {
      if (fileInput.files[0].size > 5000000) {
        displayErrorMessage("Please upload an image less than 5MB", fileInput);
        return false;
      }
    }
  }

  return true;
}

// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", (event) => {
  const form = document.querySelector("form");
  
  // Listen for changes in form inputs
  form.addEventListener("change", (e) => {
    checkForm();
  });

  // Prevent form submission if inputs are invalid
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    if (checkForm()) {
      form.submit();
    }
  });
});
