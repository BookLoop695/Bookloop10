showPasswordButton.addEventListener('click', function () {
    togglePasswordVisibility(passwordInput, showPasswordIcon);
});

function togglePasswordVisibility(inputField, eyeIcon) {
    const fieldType = inputField.getAttribute('type');
    if (fieldType === 'password') {
        inputField.setAttribute('type', 'text');
        eyeIcon.setAttribute('src', 'eye-open.png');
    } else {
        inputField.setAttribute('type', 'password');
        eyeIcon.setAttribute('src', 'eye-close.png');
    }
}

document.getElementById("signupForm").addEventListener("submit", function (event) {
    var email = document.getElementById("email").value;
    if (!email.includes("@") || !email.includes(".com")) {
        alert("Please enter a valid email address.");
        event.preventDefault(); // Prevent form submission
    }
});