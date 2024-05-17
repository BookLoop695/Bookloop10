  // Password Strength
 const passwordInput = document.getElementById('password');
 const confirmPasswordInput = document.getElementById('confirmPassword');
 const showPasswordButton = document.getElementById('showPasswordButton');
 const showPasswordIcon = document.getElementById('showPasswordIcon');
 const showConfirmPasswordButton = document.getElementById('showConfirmPasswordButton');
 const showConfirmPasswordIcon = document.getElementById('showConfirmPasswordIcon');
 const passwordHelp = document.getElementById('passwordHelp');
 const passwordHelpButton = document.getElementById('passwordHelpButton');
 const passwordStrengthBar = document.getElementById('passwordStrengthBar');
 const passwordError = document.getElementById('passwordError');
 const passwordStrengthContainer = document.querySelector('.password-strength-container');

 // Show password help on hover
 passwordInput.addEventListener('mouseenter', function () {
     passwordHelp.style.display = 'block';
 });

 // Hide password help when mouse leaves the password field
 passwordInput.addEventListener('mouseleave', function () {
     passwordHelp.style.display = 'none';
 });

 // Toggle password help visibility when the help button is clicked
 passwordHelpButton.addEventListener('click', function () {
     if (passwordHelp.style.display === 'block') {
         passwordHelp.style.display = 'none';
     } else {
         passwordHelp.style.display = 'block';
     }
 });

 // Show password strength bar when typing in password field
 passwordInput.addEventListener('input', function () {
     const password = passwordInput.value;
     const strength = calculatePasswordStrength(password);
     updatePasswordStrengthBar(strength);
     checkPasswordValidity(password);
     checkCriteria(password);
 });

 // Function to calculate password strength
 function calculatePasswordStrength(password) {
     // Your password strength calculation logic here
     // For demonstration, let's assume a simple calculation
     if (password.length < 4) {
         return 'weak';
     } else if (password.length < 6) {
         return 'medium';
     } else if (password.length < 8) {
         return 'strong';
     } else if (password.length < 19) {
         return 'very strong';
     } else {
         return 'blank';
     }
 }

 // Function to update password strength bar
 function updatePasswordStrengthBar(strength) {
     const widthMap = {
         'blank': '0%',
         'weak': '20%',
         'medium': '40%',
         'strong': '80%',
         'very strong': '100%'
     };

     passwordStrengthBar.style.width = widthMap[strength];
     passwordStrengthBar.style.backgroundColor = getStrengthColor(strength);
     passwordStrengthContainer.style.display = 'block';
 }

 // Function to get color based on password strength
 function getStrengthColor(strength) {
     switch (strength) {
         case 'weak':
             return 'red';
         case 'medium':
             return 'orange';
         case 'strong':
             return 'lightgreen';
         case 'very strong':
             return 'green';
         default:
             return 'white';
     }
 }

 // Function to check password validity
 function checkPasswordValidity(password) {
     const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

     if (!passwordPattern.test(password)) {
         passwordInput.style.borderColor = 'red';
         passwordError.style.display = 'block';
     } else {
         passwordInput.style.borderColor = '#ccc';
         passwordError.style.display = 'none';
     }
 }

 // Function to check criteria
 function checkCriteria(password) {
     const criteriaUppercase = document.getElementById('criteriaUppercase');
     const criteriaLowercase = document.getElementById('criteriaLowercase');
     const criteriaSymbol = document.getElementById('criteriaSymbol');
     const criteriaNumber = document.getElementById('criteriaNumber');

     const criteria = {
         uppercase: /[A-Z]/,
         lowercase: /[a-z]/,
         symbol: /[@$!%*?&]/,
         number: /\d/
     };

     criteriaUppercase.textContent = 'One Uppercase Letter: ' + (criteria.uppercase.test(password) ? '✓' : '✗');
     criteriaLowercase.textContent = 'One Lowercase Letter: ' + (criteria.lowercase.test(password) ? '✓' : '✗');
     criteriaSymbol.textContent = 'One Symbol: ' + (criteria.symbol.test(password) ? '✓' : '✗');
     criteriaNumber.textContent = 'One Number: ' + (criteria.number.test(password) ? '✓' : '✗');
 }

 // Show/Hide Password
 showPasswordButton.addEventListener('click', function () {
     togglePasswordVisibility(passwordInput, showPasswordIcon);
 });

 showConfirmPasswordButton.addEventListener('click', function () {
     togglePasswordVisibility(confirmPasswordInput, showConfirmPasswordIcon);
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

 confirmPasswordInput.addEventListener('input', function () {
     if (confirmPasswordInput.value !== passwordInput.value) {
         confirmPasswordError.style.display = 'block';
     } else {
         confirmPasswordError.style.display = 'none';
     }
 });
 document.getElementById("signupForm").addEventListener("submit", function (event) {
     var email = document.getElementById("email").value;
     if (!email.includes("@") || !email.includes(".com")) {
         alert("Please enter a valid email address.");
         event.preventDefault(); // Prevent form submission
     }
 });