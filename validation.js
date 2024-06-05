
function validateForm() {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  
    if (!emailPattern.test(email)) {
      alert('Please enter a valid email address.');
      return false;
    }
  
    if (password.length < 6) {
      alert('Password must be at least 6 characters long.');
      return false;
    }
  
    // If validation passes, submit the form
    document.getElementById('login-form').submit();
  }
  