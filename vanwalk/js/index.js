// Function to handle login
function handleLogin(event) {
    event.preventDefault(); // Prevent the default form submission

    const username = document.getElementById('username').value;

    // Store the username and isLogin value in sessionStorage
    sessionStorage.setItem('username', username);
    sessionStorage.setItem('isLogin', true);

    // Proceed with the form submission
    event.target.submit();
}

// Function to update the navigation bar
function updateNavBar() {
    const isLogin = sessionStorage.getItem('isLogin');
    const username = sessionStorage.getItem('username');

    if (isLogin) {
        document.getElementById('loginLink').style.display = 'none';
        document.getElementById('usernameDisplay').textContent = `Welcome, ${username}`;
        document.getElementById('usernameDisplay').style.display = 'block';
    }
}

// Update the navigation bar when the page loads
window.addEventListener('load', updateNavBar);
