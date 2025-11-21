
class YongkruApp {
  constructor() {
      this.initScrollBehavior();
      this.initMobileMenu();
      this.initProductFilters();
      this.initOrderButtons();
      this.initImageLazyLoad();
      this.initToastNotifications();
  }


  initScrollBehavior() {
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
          anchor.addEventListener('click', (e) => {
              e.preventDefault();
              const target = document.querySelector(anchor.getAttribute('href'));
              if (target) {
                  window.scrollTo({
                      top: target.offsetTop - 80,
                      behavior: 'smooth'
                  });
              }
          });
      });
  }


  initMobileMenu() {
      const navbarToggler = document.querySelector('.navbar-toggler');
      const navLinks = document.querySelectorAll('.nav-link');
      
      if (navbarToggler) {
          navbarToggler.addEventListener('click', () => {
              const target = document.querySelector(navbarToggler.dataset.bsTarget);
              target.classList.toggle('show');
          });
      }

      navLinks.forEach(link => {
          link.addEventListener('click', () => {
              const navbarCollapse = document.querySelector('.navbar-collapse');
              if (navbarCollapse) {
                  navbarCollapse.classList.remove('show');
              }
          });
      });
  }


  initProductFilters() {
      const categoryBtns = document.querySelectorAll('[data-category-filter]');
      
      categoryBtns.forEach(btn => {
          btn.addEventListener('click', (e) => {
              e.preventDefault();
              const category = btn.dataset.categoryFilter;
              
            
              categoryBtns.forEach(b => b.classList.remove('active'));
              btn.classList.add('active');
              
            
              if (category === 'all') {
                  window.location.href = "{{ route('home') }}";
              } else {
                  window.location.href = `{{ route('home') }}?category=${category}`;
              }
          });
      });
  }


  initOrderButtons() {
      document.querySelectorAll('.order-btn').forEach(btn => {
          btn.addEventListener('click', function(e) {
              if (!this.href || this.classList.contains('disabled')) {
                  e.preventDefault();
                  return;
              }
              
            
              const originalText = this.innerHTML;
              this.innerHTML = `
                  <span class="spinner-border spinner-border-sm" role="status"></span>
                  Memproses...
              `;
              this.classList.add('disabled');
              
            
              setTimeout(() => {
                  this.innerHTML = originalText;
                  this.classList.remove('disabled');
              }, 1000);
          });
      });
  }


  initImageLazyLoad() {
      const lazyImages = document.querySelectorAll('img[loading="lazy"]');
      
      if ('IntersectionObserver' in window) {
          const imageObserver = new IntersectionObserver((entries) => {
              entries.forEach(entry => {
                  if (entry.isIntersecting) {
                      const img = entry.target;
                      img.src = img.dataset.src || img.src;
                      imageObserver.unobserve(img);
                  }
              });
          });

          lazyImages.forEach(img => imageObserver.observe(img));
      }
  }


  initToastNotifications() {
      const toastEl = document.getElementById('toastNotification');
      
      if (toastEl) {
          const toast = new bootstrap.Toast(toastEl);
          
        
          if (toastEl.querySelector('.toast-body').textContent.trim() !== '') {
              toast.show();
          }
          
        
          setTimeout(() => toast.hide(), 5000);
      }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  new YongkruApp();
  

  const quantityInputs = document.querySelectorAll('.quantity-selector');
  quantityInputs.forEach(input => {
      input.addEventListener('change', function() {
          const priceElement = this.closest('.product-card').querySelector('.product-price');
          const unitPrice = parseFloat(this.dataset.unitPrice);
          const total = unitPrice * this.value;
          priceElement.textContent = `Rp ${total.toLocaleString('id-ID')}`;
      });
  });
});

function formatCurrency(amount) {
  return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
  }).format(amount);
}