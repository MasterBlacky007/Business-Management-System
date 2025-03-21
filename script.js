document.querySelector('.add-btn').addEventListener('click', function () {
    const newDisclaimer = prompt('Enter new disclaimer:');
    if (newDisclaimer) {
        const option = document.createElement('option');
        option.value = newDisclaimer;
        option.text = newDisclaimer;
        document.getElementById('disclaimer').appendChild(option);
    }
});

document.querySelector('.cancel-btn').addEventListener('click', function () {
    window.location.href = '/'; // Redirect to home or dashboard
});
document.querySelector('.cancel-btn').addEventListener('click', function () {
    if (confirm('Are you sure you want to cancel? Unsaved data will be lost.')) {
        document.getElementById('reportForm').reset();
    }
});
document.querySelector('.cancel-btn').addEventListener('click', function () {
    if (confirm('Are you sure you want to cancel? Unsaved data will be lost.')) {
        document.getElementById('reportForm').reset();
    }
});

