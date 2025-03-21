const sidebarItems = document.querySelectorAll('.sidebar ul li a'); // Select anchor tags inside list items

sidebarItems.forEach(item => {
    item.addEventListener('click', (event) => {
        // Remove 'active' class from all items
        sidebarItems.forEach(link => link.parentElement.classList.remove('active'));

        // Add 'active' class to the parent list item of the clicked link
        item.parentElement.classList.add('active');
    });
});