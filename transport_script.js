// Handle cancel button action
document.querySelector('.cancel-btn').addEventListener('click', function () {
    if (confirm('Are you sure you want to cancel? Unsaved data will be lost.')) {
        window.history.back();
    }
});
