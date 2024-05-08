// Importing functions from functions.js
import { iconsAudio } from "./functions.js";

// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", (event) => {
  // Call the iconsAudio function
  iconsAudio();

  // Get the comment button element
  const commentButton = document.getElementById("comment");

  // Get the recipe ID value
  const recipeId = document.getElementById("recipeId").value;

  // Add event listener to the comment button
  commentButton.addEventListener("click", () => {
    // Prompt the user to write a comment
    let comment = prompt("Write your comment", "Nice recipe");

    // Check if a comment was entered
    if (comment && comment.length <= 150) {
      // Redirect to the comment.php page with the comment and recipe ID as query parameters
      window.location.replace(
        "./comment.php?comment=" + comment + "&recipeId=" + recipeId
      );
    }
  });
});
