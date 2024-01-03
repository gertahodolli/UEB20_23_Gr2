document.addEventListener('DOMContentLoaded', function() {
    // Show data for different dates
    const shows = [
        { date: '27', title: '1984', director: 'Director 1', runningTime: '1 hour', image: '../resources/shows/1984.png' },
        { date: '28', title: 'Club Albania', director: 'Director 2', runningTime: '1.5 hours', image: '../resources/shows/club albania.png' },
        { date: '30', title: 'Grate', director: 'Director 3', runningTime: '2 hours', image: '../resources/shows/Grate.png' },
        { date: '3', title: 'Dite Vere', director: 'Director 3', runningTime: '2 hours', image: '../resources/shows/Ditevere.jpg' },
        { date: '5', title: 'Udhetim i gjate drejt nates', director: 'Director 3', runningTime: '2 hours', image: '../resources/shows/udhetimi gjate drejt nates.png' },
        { date: '9', title: 'Diqka rreth IV', director: 'Director 3', runningTime: '2 hours', image: '../resources/shows/diqka rreth IV.png' },
        
    ];

    // Function to update show information based on the selected date
    function updateShowInfo(date) {
        const show = shows.find(show => show.date === date);
        if (show) {
            document.getElementById('showTitle').innerText = show.title;
            document.getElementById('selectedDate').innerText = `Date: December ${show.date}`;
            document.getElementById('director').innerText = `Director: ${show.director}`;
            document.getElementById('runningTime').innerText = `Running Time: ${show.runningTime}`;
            document.getElementById('showImage').src = show.image;
        } else {
            // If no show found for the date, update with default text or image
            document.getElementById('showTitle').innerText = 'No Show Available';
            document.getElementById('selectedDate').innerText = `Date: December ${date}`;
            document.getElementById('director').innerText = '';
            document.getElementById('runningTime').innerText = '';
            document.getElementById('showImage').src = 'defaultImage.jpg';
        }
    }

   
    // Add event listeners to each date link
    document.querySelectorAll('.date-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior
            const selectedDate = this.textContent.trim(); // Get the selected date
            updateShowInfo(selectedDate); // Update show information based on the selected date
        });
    });
    });