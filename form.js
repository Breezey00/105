
  
// ===== Page elements =====
const form = document.getElementById("contactForm");
const nameInput = document.getElementById("fullname");
const emailInput = document.getElementById("email");
const messageInput = document.getElementById("message");
const result = document.getElementById("result")
const errorList = document.getElementById("formErrors");
const checkbox = document.getElementById("allow");
const button = document.getElementById("butt");

// ===== Submit handler =====
// The function runs when a submit event hapepens in the form,
//  preventDefault keeps the default browser's reaction to the submit vent
form.addEventListener("submit", function (e) {
    

    // the name, email, message inputs in the form's values are taken and trimmed,
    //  and assigned to the constants  fullname, email and message repectively
    const fullname = nameInput.value.trim();
    const email = emailInput.value.trim();
    const message = messageInput.value.trim();

    // The 1st "if" statement pushes an error if there is no input on the name form
    // 2nd statement pushes an error if the email has no "@" included or if the email has a "."(a period)
   // 3rd statement pushes an error if the message input has greater than 10 characters
    const errors = [];

    if (fullname === "") {
        errors.push("Full name is required.");
    }
    if (!email.includes("@") || !email.includes(".")) {
        errors.push("Enter a valid email address.");
    }
    if (message.length < 10) {
        errors.push("Message must be at least 10 characters.");
    }

    // Because everything that happens within this function (errors being put on a list and returned) doesn't get sent the default way
    if (errors.length > 0) {
        e.preventDefault();
        
        errorList.innerHTML = errors.map(function (msg) {
            return "<li>" + msg + "</li>";
        }).join("");

        return;
    }

    // the form returns a blank line as the only String in the errorList variable 
    errorList.innerHTML = "";
    });

    // ===== Live character count =====
    const charCount = document.getElementById("charCount");

    //it runs when the user writes in the message box, and  it shows the char length/count
    messageInput.addEventListener("input", function () {
    charCount.textContent = messageInput.value.length + " characters";

});
// added event listener for checkbox
// disabled button at contact.html by default
checkbox.addEventListener("change", function(e) {

    //disables the disable on the contact.html if the checkbox remain unchecked
 button.disabled = !checkbox.checked;
});
