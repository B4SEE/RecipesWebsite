### Project Overview:
The recipe website was created as a semester project for the ZWA subject. It was written in html, css, javascript, php without the use of third-party libraries and/or frameworks.

### Code Structure and Organization:
There are several pages of the site and files with functions. Each page has code that is responsible for the content on its specific page and can use universal functions or its own special ones. Duplicate selections are imported and stored in separate files (header, footer, etc.). Each file has comments explaining the code sections. JavaScript files are divided into files with code for a specific page and a file with functions. The style for each page is stored in a separate file, and there is also one common style file where variables (colours) and the general style are defined. All files are located in the www folder.

### File and Folder Structure:
Static files are located in the PROJECT_files and PROJECT_files/sounds folders. User files are located in the uploads folder and are arranged as follows: uploads/username/filename. User avatars, user recipe images, and cropped versions of recipe images are stored in uploads (always 1 cropped photo, if a page creates a new one, the new one replaces the old one).

### Data Storage:
All text data and image paths are stored in the database (recipes, comments, ingredients, users).

### User Functionalities:
- **Guest User (Not Logged In):**
  - View recipes and utilize the search functionality.
  - Access the login or registration pages.

- **Registered and Logged-In Users:**
  - Log out of the system.
  - Add a new recipe, edit their existing recipes, and delete their recipes.
  - Add comments to any recipe and delete their comments.

- **Admin Users:**
  - Enjoy all functionalities available to registered users.
  - Create, edit, and delete any recipes on the platform.
  - Leave comments on recipes.
  - Access an admin-specific page to view comprehensive user information.
  - Delete any user, including all associated recipes and comments.
  - Perform user impersonation for debugging or support purposes.

### Comments with File Explanations:

#### php files:
1. **index.php:**
   - Home page with popular recipes, featuring a hero section and a recipe display.
   - Session management ensures an active session for users.
   - Includes CSS and JavaScript files for styling and interactivity.
   -  "Add recipe" button redirects to the page for editing a new recipe for logged-in users. If the user is not logged in, it redirects them to the login page.
   - "User control" button is visible only for admins.

2. **doSearch.php:**
   - Manages the search functionality, retrieving input from GET or POST requests.
   - Conducts searches in the database and displays results in a paginated manner.
   - Handles navigation between pages of search results.

3. **signup.php:**
   - Manages user sign-up functionality, validating username, email, password, and profile image inputs.
   - Creates a new user account if input is valid, redirecting to the index page; displays error messages otherwise.

4. **login.php:**
   - Contains user login functionality, handling authentication and session management.

5. **recipe.php:**
   - Displays a recipe page, retrieving details from the database and allowing various user interactions.
   - Users can view, edit (if authorized), delete (if authorized), and comment on recipes.

6. **edit.php:**
   - Handles the editing of a recipe, checking user login status and updating recipe information in the database.
   - Manages file uploads for recipe images.

7. **about_us.php:**
   - Represents the "About Us" page, including HTML, CSS, and JavaScript files.
   - Initiates the session if not already active, with a structure including header, main content, and footer sections.

8. **admin_page.php:**
   - Displays a recipe page with admin functionalities for viewing, editing, deleting, and commenting.
   - Similar to the recipe.php but with additional capabilities for admins.

9. **header.php:**
   - Represents the header section, displaying the logo, navigation menu, search bar, and login button.
   - Navigation menu includes links to recipe categories and an "About Us" link.
   - Dynamic display of "Login" or "Logout" based on user login status.

10. **config.php:**
    - Configuration file managing the database connection.

11. **create.php:**
    - Adds data to the specified table in the database.

12. **read.php:**
    - Retrieves rows from a database table based on specific column values.
    - Handles various retrieval scenarios, providing flexibility in data access.

13. **upload.php:**
    - Updates data in the specified table based on the given ID.
    - Manages the modification of existing data in the database.

14. **delete.php:**
    - Deletes data from the specified table by the given ID or based on a specific column and its value.
    - Includes functions for targeted data deletion.

15. **getUser.php:**
    - Displays user information in HTML format.
    - Contains functions for echoing user information, handling user deletion, and user login.

16. **comment.php:**
    - Manages comments on the website.
    - Checks user login status, adds or deletes comments from the database, and redirects the user accordingly.

17. **crud.php:**
    - Houses functions for performing CRUD operations on the database and other utility functions.
    - Provides a set of functions ranging from data retrieval to user interface rendering and file manipulation.

#### javascript files:

1. **admin.js:**
   - Description: This file handles the functionality related to the admin page. It imports functions from the functions.js file and waits for the DOM to be fully loaded.
     - Selects the 'select' element with the name "users" and the 'input' element with the name "input_users."
     - Adds an event listener for the 'change' event on the select element, calling the `showUser` function with the selected value as the argument.
     - Adds an event listener for the 'keyup' event on the input element, calling the `showAllUsers` function with the input value as the argument.

2. **comment.js:**
   - Description: This file manages the functionality related to adding comments. It imports functions from functions.js and waits for the DOM to be fully loaded.
     - Calls the `iconsAudio` function to initialize audio functionality.
     - Retrieves the comment button element and the recipe ID value.
     - Adds an event listener to the comment button.
     - Prompts the user to write a comment, checks if a comment was entered, and redirects to the comment.php page with the comment and recipe ID as query parameters.

3. **edit.js:**
   - Description: This file focuses on the validation aspect of editing recipes.
     - Validates the form inputs for editing recipes, ensuring that the entered data is correct and complete.

4. **functions.js:**
   - Description: This file contains a set of reusable functions utilized across various pages. It includes:
     - Initialization of audio functionality for icons.
     - A function to play a specified audio element.
     - A function to stop all audio playback.
     - A function to suspend the execution of the current function for a specified number of milliseconds.
     - A function to display an error message next to an input element.
     - A function to display the name of an image associated with an input element.
     - Functions to retrieve and display user information based on user ID and to retrieve and display all users based on a provided string.

5. **index.js:**
   - Description: This file is responsible for calling the `iconsAudio` function. It initializes audio functionality for icons on the index page.

6. **login.js:**
   - Description: This file handles the validation of form inputs during the login process. It includes:
     - A function to validate form inputs and display error messages if necessary.
     - The function returns true if the form inputs are valid and false otherwise.

7. **signup.js:**
   - Description: This file manages the validation of form inputs during the sign-up process. It includes:
     - A function to validate form inputs and display error messages if necessary.
     - The function returns true if the form inputs are valid and false otherwise.

This documentation serves as a comprehensive guide to the intricacies and functionalities of the recipe website developed as a semester project for the ZWA subject.