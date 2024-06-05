
function fadeIn(element, duration) {
    element.style.opacity = 0;
    var startTime = performance.now();
  
    function animate(currentTime) {
      var elapsedTime = currentTime - startTime;
      var progress = elapsedTime / duration;
  
      element.style.opacity = Math.min(progress, 1);
  
      if (progress < 1) {
        requestAnimationFrame(animate);
      }
    }
  
    requestAnimationFrame(animate);
  }
  
  window.onload = function() {
    var elementsToFadeIn = document.querySelectorAll('.fade-in');
  
    elementsToFadeIn.forEach(function(element) {
      fadeIn(element, 1000); 
    });
  };
  
  document.addEventListener("DOMContentLoaded", function() {
    const roleElements = document.querySelectorAll(".role");

    function checkVisibility() {
        roleElements.forEach(role => {
            if (isElementInViewport(role)) {
                role.classList.add("visible");
            }
        });
    }

    function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Initial check
    checkVisibility();

    // Check visibility on scroll
    window.addEventListener("scroll", checkVisibility);

    // Typewriter effect
    const textElement = document.getElementById('typewriter');
    const textDescriptionElement = document.getElementById('typewriter-description');
    const text = textElement.innerText;
    const textDescription = textDescriptionElement.innerText;
    textElement.innerText = '';
    textDescriptionElement.innerText = '';

    let i = 0;
    let j = 0;

    function type() {
        if (i < text.length) {
            if (text.charAt(i) === ' ') {
                textElement.innerHTML += '&nbsp;';
            } else {
                textElement.innerText += text.charAt(i);
            }
            i++;
            setTimeout(type, 100); // Slower typing speed
        } else if (j < textDescription.length) {
            if (textDescription.charAt(j) === ' ') {
                textDescriptionElement.innerHTML += '&nbsp;';
            } else {
                textDescriptionElement.innerText += textDescription.charAt(j);
            }
            j++;
            setTimeout(type, 70); // Slower typing speed
        }
    }

    type();
});


