const shows = [
    {
      imageUrl: '../resources/images/aboutUs.jpg',
      name: '1984',
      director: "Igor Mendjisky",
      runningTime: '1:30'
    },
    {
      imageUrl: '../resources/images/aboutUs(2).jpg',
      name: 'CLUB ALBANIA',
      director: "Fatos Berisha",
      runningTime: '2:00'
    },
    ];
  
      let currentIndex = 0;
      const fullPage = document.querySelector('.full-page');
      const showNameElement = document.getElementById('showName');
      const directorElement = document.getElementById('director');
      const runningTimeElement = document.getElementById('runningTime');
  
      function changeBackground(image) {
        fullPage.style.backgroundImage = `url('${image}')`;
      }
  
      function displayShow(index) {
        const show = shows[index];
        changeBackground(show.imageUrl);
        showNameElement.textContent = show.name;
        directorElement.textContent = `Director: ${show.director}`;
        runningTimeElement.textContent = `Running Time: ${show.runningTime}`;
      }
  
      function startSlideshow() {
        setInterval(() => {
          currentIndex = (currentIndex + 1) % shows.length;
          displayShow(currentIndex);
        }, 5000); // Change shows every 5 seconds (5000 milliseconds)
      }
  
      function nextSlide() {
        currentIndex = (currentIndex + 1) % shows.length;
        displayShow(currentIndex);
      }
  
      function prevSlide() {
        currentIndex = (currentIndex - 1 + shows.length) % shows.length;
        displayShow(currentIndex);
      }
  
      startSlideshow(); // Start the slideshow when the page loads
  
      const leftButton = document.querySelector('.hover-button.left');
      const rightButton = document.querySelector('.hover-button.right');
  
      leftButton.addEventListener('click', prevSlide);
      rightButton.addEventListener('click', nextSlide);