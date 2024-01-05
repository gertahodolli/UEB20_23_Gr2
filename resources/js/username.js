const usernameField = document.querySelector("#username-field");
const usernameRules = document.querySelector(".username-rules");
const usernameSuccess = document.querySelector(".username-success");
usernameField.addEventListener("input", () => usernameChangeHandler(usernameField.value));
const usernamePattern = /^[a-z][a-z0-9]{7,29}$/i
function usernameChangeHandler(userInput) {
  if (usernamePattern.test(userInput)) {
    showGood()
  } else {
    showBad()
  }
}
function showGood() {
  usernameSuccess.classList.remove("hidden");
  usernameRules.classList.add("hidden");
}
function showBad() {
  usernameSuccess.classList.add("hidden");
  usernameRules.classList.remove("hidden");
}