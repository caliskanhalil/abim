// Sayfadaki "baslik" adlı elementi bul
const baslik = document.getElementById("baslik");

// Tıklanınca çalışan bir olay ekle
baslik.addEventListener("click", function() {
  baslik.textContent = "Sitemize Hoş Geldiniz!";
});


// Sayfa tamamen yüklendiğinde çalıştır
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
  
    form.addEventListener("submit", function(e) {
      e.preventDefault();
  
      const ad = document.getElementById("ad").value;
      const email = document.getElementById("email").value;
      const mesaj = document.getElementById("mesaj").value;
  
      if (ad && email && mesaj) {
        alert("Teşekkürler " + ad + "! Mesajın gönderildi 😊");
        form.reset();
      } else {
        alert("Lütfen tüm alanları doldurun ⚠️");
      }
    });
  });
  let students = document.getElementById('students');
let courses = document.getElementById('courses');
let projects = document.getElementById('projects');

let counts = [500, 30, 100]; // Örnek rakamlar
let speed = 50; // Ne kadar hızlı artsın

function countUp(element, target) {
  let count = 0;
  let interval = setInterval(() => {
    count++;
    element.innerText = count;
    if (count >= target) {
      clearInterval(interval);
    }
  }, speed);
}

window.addEventListener('load', () => {
  countUp(students, counts[0]);
  countUp(courses, counts[1]);
  countUp(projects, counts[2]);
});





let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

document.querySelector('.next').addEventListener('click', () => {
  goToSlide(currentSlide + 1);
});

document.querySelector('.prev').addEventListener('click', () => {
  goToSlide(currentSlide - 1);
});

function goToSlide(n) {
  currentSlide = (n + totalSlides) % totalSlides;
  const container = document.querySelector('.slides-container');
  container.style.transform = `translateX(-${currentSlide * 100}%)`;
}

// Otomatik geçiş
setInterval(() => {
  goToSlide(currentSlide + 1);
}, 5000);




const container = document.querySelector('.testimonials-container');
  let isDown = false, startX, scrollLeft;

  // Fare ile sürükleme
  container.addEventListener('mousedown', e => {
    isDown = true;
    container.classList.add('dragging');
    startX = e.pageX - container.offsetLeft;
    scrollLeft = container.scrollLeft;
  });
  container.addEventListener('mouseleave', () => {
    isDown = false;
    container.classList.remove('dragging');
  });
  container.addEventListener('mouseup', () => {
    isDown = false;
    container.classList.remove('dragging');
  });
  container.addEventListener('mousemove', e => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - container.offsetLeft;
    const walk = (x - startX) * 1.5; // kaydırma hızı
    container.scrollLeft = scrollLeft - walk;
  });

  // Otomatik kaydırma
  function autoScroll() {
    const maxScroll = container.scrollWidth - container.clientWidth;
    if (Math.ceil(container.scrollLeft) >= maxScroll) {
      container.scrollTo({ left: 0, behavior: 'smooth' });
    } else {
      container.scrollBy({ left: container.clientWidth, behavior: 'smooth' });
    }
  }
  let interval = setInterval(autoScroll, 5000);

  // Hover’da duraklat
  container.addEventListener('mouseenter', () => clearInterval(interval));
  container.addEventListener('mouseleave', () => interval = setInterval(autoScroll, 5000));