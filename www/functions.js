/**
 * Initializes the audio functionality for the icons.
 */
function iconsAudio() {
  const youtube = document.getElementById("Youtube");
  const twitter = document.getElementById("Twitter");
  const browser = document.getElementById("Browser");
  const pinterest = document.getElementById("Pinterest");

  var audioYoutube = new Audio("PROJECT_files/sounds/youtube.mp3");
  var audioTwitter = new Audio("PROJECT_files/sounds/twitter.mp3");
  var audioBrowser = new Audio("PROJECT_files/sounds/browser.mp3");
  var audioPinterest = new Audio("PROJECT_files/sounds/pinterest.mp3");

  /**
   * Plays the specified audio.
   * @param {HTMLAudioElement} audio - The audio element to be played.
   * @returns {void}
   */
  function playAudio(audio) {
    audio.play();
  }

  /**
   * Stops all audio playback.
   */
  function stopAudio() {
    audioYoutube.pause();
    audioTwitter.pause();
    audioBrowser.pause();
    audioPinterest.pause();
  }

  youtube.addEventListener("click", () => {
    stopAudio();
    playAudio(audioYoutube);
  });
  twitter.addEventListener("click", () => {
    stopAudio();
    playAudio(audioTwitter);
  });
  browser.addEventListener("click", () => {
    stopAudio();
    playAudio(audioBrowser);
  });
  pinterest.addEventListener("click", () => {
    stopAudio();
    playAudio(audioPinterest);
  });
}

/**
 * Suspends the execution of the current function for a specified number of milliseconds.
 * @param {number} ms - The number of milliseconds to sleep.
 * @returns {Promise<void>} A promise that resolves after the specified number of milliseconds.
 */
function sleep(ms) {
  return new Promise((resolve) => setTimeout(resolve, ms));
}

/**
 * Displays an error message next to an input element.
 *
 * @param {string} message - The error message to display.
 * @param {HTMLElement} input - The input element to display the error message next to.
 */
function displayErrorMessage(message, input) {
  const errorMessage = document.createElement("p");
  errorMessage.classList.add("error");
  errorMessage.textContent = message;
  errorMessage.style.color = "red";
  errorMessage.style.margin = "0";
  input.parentNode.insertBefore(errorMessage, input.nextSibling);
}

/**
 * Displays the name of an image.
 *
 * @param {string} name - The name of the image.
 * @param {HTMLElement} input - The input element associated with the image.
 */
function showImageName(name, input) {
  if (document.querySelector(".image-name")) {
    document.querySelector(".image-name").remove();
  }
  const imageName = document.createElement("p");
  imageName.classList.add("image-name");
  imageName.textContent = name;
  imageName.style.margin = "0";
  imageName.style.padding = "0";
  imageName.style.color = "black";
  imageName.style.fontWeight = "bold";
  input.parentNode.insertBefore(imageName, input.nextSibling);
}

/**
 * Retrieves user information and displays it in the HTML element with the id "txtHint".
 * @param {string} str - The user ID to retrieve user information for.
 */
function showUser(str) {
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    document.getElementById("txtHint").innerHTML = this.responseText;
  };
  xhttp.open("GET", "getUser.php?userId=" + str);
  xhttp.send();
}

/**
 * Retrieves and displays all users based on the provided string.
 * @param {string} str - The string used to filter the users.
 */
function showAllUsers(str) {
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    document.getElementById("txtHint").innerHTML = this.responseText;
  };
  xhttp.open("GET", "getUser.php?all=true&username=" + str);
  xhttp.send();
}

export { iconsAudio };
export { sleep };
export { displayErrorMessage };
export { showImageName };
export { showUser };
export { showAllUsers };
