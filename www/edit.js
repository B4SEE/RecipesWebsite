// Description: Edit recipe validation

// Importing functions from functions.js
import { displayErrorMessage, showImageName, sleep } from "./functions.js";

// Function to remove the last ingredient from the ingredients array and add it back to the select dropdown
function removeLastIngredient(ingredients) {
  var lastIngredient = ingredients.pop();
  var select = document.getElementById("ingredients");
  var option = document.createElement("option");
  option.text = lastIngredient;
  option.value = lastIngredient;
  select.add(option);
}

/**
 * Validates the input fields for editing.
 *
 * @returns {boolean} Returns true if all input fields are valid, otherwise false.
 */
function checkEdit() {
  var name = document.querySelector("#name").value;
  var description = document.querySelector("#description").value;
  const image = document.querySelector("#image");

  const errorMessages = document.querySelectorAll(".error");
  errorMessages.forEach((errorMessage) => {
    errorMessage.remove();
  });

  // Validate name field
  if (name === "") {
    displayErrorMessage("Please enter a name", document.querySelector("#name"));
    return false;
  } else if (name.trim().length === 0) {
    displayErrorMessage(
      "Name input cannot be just spaces",
      document.querySelector("#name")
    );
    return false;
  } else {
    if (!name.match(/^[a-zA-Z0-9,.:;-_!?()%'"\s]*$/)) {
      name = name.replace(/[^a-zA-Z0-9,.:;-_!?()%'"\s]/g, "");
      displayErrorMessage(
        "Use of prohibited characters, prohibited characters will be removed from the text",
        document.querySelector("#name")
      );
      sleep(2000).then(() => {
        document.querySelector("#name").value = name;
      });
      return false;
    }
    if (name.length < 2) {
      displayErrorMessage(
        "Name must be at least 2 characters long",
        document.querySelector("#name")
      );
      return false;
    } else if (name.length > 50) {
      displayErrorMessage(
        "Name must be less than 50 characters long",
        document.querySelector("#name")
      );
      return false;
    }
  }

  // Validate description field
  if (description === "") {
    displayErrorMessage(
      "Please enter a description",
      document.querySelector("#description")
    );
    return false;
  } else if (description.trim().length === 0) {
    displayErrorMessage(
      "Description input cannot be just spaces",
      document.querySelector("#description")
    );
    return false;
  } else {
    if (!description.match(/^[a-zA-Z0-9,.:;-_!?()%'"\s\n]*$/)) {
      description = description.replace(/[^a-zA-Z0-9,.:;-_!?()%'"\s\n]/g, "");
      displayErrorMessage(
        "Use of prohibited characters, prohibited characters will be removed from the text",
        document.querySelector("#description")
      );
      sleep(2000).then(() => {
        document.querySelector("#description").value = description;
      });
      return false;
    } else if (description.length < 20) {
      displayErrorMessage(
        "Description must be at least 20 characters long",
        document.querySelector("#description")
      );
      return false;
    } else if (description.length > 3000) {
      displayErrorMessage(
        "Description must be less than 3000 characters long",
        document.querySelector("#description")
      );
      return false;
    }
  }

  // Validate ingredients field
  if (
    ingredientsList.value.trim() === "" ||
    ingredientsList.value.trim() === "null"
  ) {
    displayErrorMessage(
      "Please select at least 1 ingredient",
      document.querySelector("#ingredientsList")
    );
    return false;
  }

  // Validate image field
  if (image.value.trim() === "") {
    displayErrorMessage(
      "Please select image",
      document.querySelector("#image")
    );
    return false;
  } else {
    showImageName(image.files[0].name, image);
    var allowedFiles = [".jpeg", ".png", ".jpg"];
    var regex = new RegExp(
      "([a-zA-Z0-9s_\\.-:])+(" + allowedFiles.join("|") + ")$"
    );
    if (!regex.test(image.value.toLowerCase())) {
      displayErrorMessage(
        "Only .jpeg, .png, .jpg files allowed",
        document.querySelector("#image")
      );
      return false;
    } else {
      if (image.files[0].size > 5000000) {
        displayErrorMessage(
          "Image must be less than 5MB",
          document.querySelector("#image")
        );
        return false;
      }
    }
  }
  return true;
}

// Waiting for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", (event) => {
  const form = document.querySelector("form");
  const button_add_ingredient = document.querySelector("#add_ingredient");
  const button_undo = document.querySelector("#undo");
  const ingredientsList = document.querySelector("#ingredientsList");

  var ingredients = [];
  var x = 0;
  let results = document.getElementById("resultShowHere");
  let ingredient = document.getElementById("ingredients");

  // Check if there are any pre-selected ingredients and remove them from the select dropdown
  if (ingredientsList.value !== "") {
    ingredients = ingredientsList.value.split(",");
    results.innerHTML = '"' + ingredients + '"';
    x = ingredients.length;
    for (var i = 0; i < ingredients.length; i++) {
      const option = document.querySelector(
        "#ingredients option[value='" + ingredients[i] + "']"
      );
      if (option && option.value === ingredients[i]) {
        option.remove();
      }
    }
  }

  // Event listener for adding an ingredient
  button_add_ingredient.addEventListener("click", (e) => {
    e.preventDefault();
    if (
      ingredient === null ||
      ingredient.value === "null" ||
      ingredient.options.length === 0
    ) {
      return; // Exit the function if there is no ingredient selected or no options left
    }
    ingredients[x] = ingredient.value;
    results.innerHTML = '"' + ingredients + '"';
    ingredient.remove(ingredient.selectedIndex);
    x++;
    ingredientsList.value = ingredients.toString();
  });

  // Event listener for undoing the last ingredient addition
  button_undo.addEventListener("click", (e) => {
    e.preventDefault();
    if (ingredients.length > 0) {
      removeLastIngredient(ingredients);
      results.innerHTML = '"' + ingredients + '"';
      x--;
      ingredientsList.value = ingredients.toString();
    }
  });

  // Event listener for form input changes
  form.addEventListener("change", (e) => {
    e.preventDefault();

    checkEdit();
  });

  // Event listener for form submission
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    if (checkEdit()) {
      form.submit();
    }
  });
});
