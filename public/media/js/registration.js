document.addEventListener('DOMContentLoaded', function () {
    showPopup();
});

function showPopup() {
    var alertDiv = document.getElementById('custom-alert');
    if (alertDiv) {
        alertDiv.style.display = 'block';
        setTimeout(function () {
            hidePopup();
        }, 3000); // Adjust the timeout duration (in milliseconds) as needed
    }
}

function hidePopup() {
    var alertDiv = document.getElementById('custom-alert');
    if (alertDiv) {
        alertDiv.style.display = 'none';
    }
}