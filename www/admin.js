// Importing functions from functions.js
import { showUser, showAllUsers } from "./functions.js";

// Waiting for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", function () {
  // Selecting the 'select' element with name "users"
  const selectElement = document.querySelector('select[name="users"]');

  // Selecting the 'input' element with name "input_users"
  const inputElement = document.querySelector('input[name="input_users"]');

  // Adding an event listener for the 'change' event on the select element
  selectElement.addEventListener("change", function () {
    // Calling the showUser function with the selected value as the argument
    showUser(this.value);
  });

  // Adding an event listener for the 'keyup' event on the input element
  inputElement.addEventListener("keyup", function () {
    // Calling the showAllUsers function with the input value as the argument
    showAllUsers(this.value);
  });
});
