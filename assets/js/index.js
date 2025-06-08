  // Animation au défilement
  document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate__animated', 'animate__fadeInUp');
        }
      });
    }, {
      threshold: 0.1
    });
    
    document.querySelectorAll('.feature-card, .eco-badge, .testimonial').forEach(el => {
      observer.observe(el);
    });
    
    // Service Worker
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/sw.js')
        .then(reg => console.log('✅ Service Worker actif', reg))
        .catch(err => console.warn('❌ SW erreur', err));
    }
  });
