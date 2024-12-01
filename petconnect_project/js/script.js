// Wait for the DOM to load completely
document.addEventListener('DOMContentLoaded', () => {
  
    // Feature 1: Dynamic Search Bar
    document.querySelector('.search-bar').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const services = document.querySelectorAll('.service');
    
        services.forEach(service => {
            const serviceText = service.textContent.toLowerCase();
            if (serviceText.includes(searchTerm)) {
                service.style.display = 'block'; // Show matching service
            } else {
                service.style.display = 'none'; // Hide non-matching service
            }
        });
    });

    // Feature 2: Interactive Find Services Button
    document.querySelector('.btn').addEventListener('click', function () {
        const searchTerm = document.querySelector('.search-bar').value;
        if (searchTerm.trim() === "") {
            alert("Please enter a search term!");
        } else {
            alert(`Searching for "${searchTerm}"...`);
            // In the future, this could redirect to a results page or trigger a search
        }
    });

    // Feature 3: Search Form Submission (AJAX)
    document.getElementById('search-form').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the form from submitting normally

        const query = document.getElementById('search-input').value;
        const resultsContainer = document.getElementById('results-container');

        // Perform an AJAX request to fetch search results
        fetch(`search_services.php?query=${encodeURIComponent(query)}`)
            .then(response => response.text())
            .then(data => {
                resultsContainer.innerHTML = data; // Update the results dynamically
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
                resultsContainer.innerHTML = '<p>An error occurred while fetching results.</p>';
            });
    });

    // Feature 4: View Bookings Form Submission (AJAX)
    document.getElementById('view-bookings-form').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission

        const email = document.getElementById('email').value;
        const bookingsContainer = document.getElementById('bookings-container');

        // Perform an AJAX request to fetch bookings
        fetch(`user_bookings.php?email=${encodeURIComponent(email)}`)
            .then(response => response.text())
            .then(data => {
                bookingsContainer.innerHTML = data; // Display bookings dynamically
            })
            .catch(error => {
                console.error('Error fetching bookings:', error);
                bookingsContainer.innerHTML = '<p>An error occurred while fetching your bookings.</p>';
            });
    });

    // Feature 5: Load available services into the dropdown
    fetch('fetch_services.php')
        .then(response => response.json())
        .then(services => {
            const serviceDropdown = document.getElementById('service');
            services.forEach(service => {
                const option = document.createElement('option');
                option.value = service.id;
                option.textContent = `${service.name} (${service.type})`;
                serviceDropdown.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching services:', error));

    // Feature 6: Handle Booking Form Submission with AJAX
    const bookingForm = document.getElementById('booking-form');
    bookingForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission behavior

        // Validate form fields
        const service = document.getElementById('service').value;
        const date = document.getElementById('date').value;
        const time = document.getElementById('time').value;

        // Ensure all fields are filled out
        if (!service || !date || !time) {
            alert("Please fill out all required fields!");
            return;
        }

        // If all fields are valid, submit the form
        const formData = new FormData(bookingForm);

        // You can handle form submission with AJAX to avoid page reload
        fetch(bookingForm.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(result => {
            alert(result); // Display the result message from the server (e.g., success or error)
            bookingForm.reset(); // Reset the form fields
        })
        .catch(error => {
            console.error('Error submitting booking:', error);
            alert('There was an issue with your booking. Please try again.');
        });
    });

});
