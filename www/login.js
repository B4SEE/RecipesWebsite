// Importing functions from functions.js
import { displayErrorMessage } from "./functions.js";

// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", (event) => {
  const form = document.querySelector("form");

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const usernameInput = document.getElementById("username_input");
    const passwordInput = document.getElementById("password_input");

    const errorMessages = document.querySelectorAll(".error-message");
    errorMessages.forEach((errorMessage) => {
      errorMessage.remove();
    });

    // Check if username is empty
    if (usernameInput.value.trim() === "") {
      displayErrorMessage("Please enter your username", usernameInput);
      return;
    }

    // Check if password is empty
    if (passwordInput.value.trim() === "") {
      displayErrorMessage("Please enter your password", passwordInput);
      return;
    }

    form.submit();
  });
});
