let slideIndex = 0;
let slideTimeout;

function showSlides(n = null) {
    let slides = document.getElementsByClassName("slide");

    // Clear any existing timeout to avoid conflicts
    clearTimeout(slideTimeout);

    // If n is passed, update the slideIndex accordingly
    if (n !== null) {
        slideIndex = n - 1; // Adjust index to match array (0-based index)
    } else {
        // Otherwise, move to the next slide automatically
        slideIndex++;
    }

    if (slideIndex >= slides.length) { slideIndex = 0; }
    if (slideIndex < 0) { slideIndex = slides.length - 1; }

    // Hide all slides
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
    }

    // Show the current slide
    slides[slideIndex].classList.add("active");

    // Automatically change slide every 3 seconds
    slideTimeout = setTimeout(showSlides, 3000);
}

// Function for button click to jump to a specific slide
function currentSlide(n) {
    showSlides(n);
}

// Call the function to start the slideshow
showSlides();