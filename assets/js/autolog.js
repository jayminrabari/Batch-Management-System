// Check if the current page URL contains 'admin_auth.php' (login page URL)
if (document.referrer.includes('admin_auth.php')) {
    // Redirect to logout.php to perform automatic logout
    window.location.href = 'admin_auth_logout.php';
}
