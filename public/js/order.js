
class OrderForm {
    constructor() {
        this.form = document.getElementById('order-form');
        this.submitBtn = this.form?.querySelector('button[type="submit"]');
        this.loadingSpinner = document.getElementById('loading-spinner');
        this.submitText = document.getElementById('submit-text');
        this.orderSummary = document.getElementById('order-summary');
        this.summaryContent = document.getElementById('summary-content');
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        
        this.init();
    }

    init() {
        if (!this.form) return;

    
        this.form.querySelectorAll('input, textarea').forEach(input => {
            input.addEventListener('input', this.validateField.bind(this, input));
        });

    
        this.form.addEventListener('submit', this.handleSubmit.bind(this));
    }

    validateField(field) {
    
        if (field.required && !field.value.trim()) {
            field.classList.add('is-invalid');
            return false;
        }
        
    
        if (field.type === 'email' && !this.validateEmail(field.value)) {
            field.classList.add('is-invalid');
            return false;
        }
        
    
        if (field.name === 'phone' && !this.validatePhone(field.value)) {
            field.classList.add('is-invalid');
            return false;
        }

        field.classList.remove('is-invalid');
        return true;
    }

    validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    validatePhone(phone) {
        return /^[0-9+\-\s]{10,15}$/.test(phone);
    }

    async handleSubmit(e) {
        e.preventDefault();
        
    
        let isValid = true;
        this.form.querySelectorAll('input[required], textarea[required]').forEach(field => {
            if (!this.validateField(field)) isValid = false;
        });
        
        if (!isValid) {
            this.showError('Harap isi semua field dengan benar');
            return;
        }

        this.setLoading(true);

        try {
            const response = await this.submitForm();
            
            if (response.ok) {
                const data = await response.json();
                this.handleSuccess(data);
            } else {
                this.handleError(response);
            }
        } catch (error) {
            console.error('Order error:', error);
            this.showError('Terjadi kesalahan jaringan');
        } finally {
            this.setLoading(false);
        }
    }

    async submitForm() {
        const formData = new FormData(this.form);
        
    
        const price = parseFloat(this.form.dataset.productPrice);
        const quantity = parseInt(formData.get('quantity'));
        formData.append('total_price', (price * quantity).toFixed(2));
        
        return fetch(this.form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': this.csrfToken,
                'Accept': 'application/json'
            }
        });
    }

    handleSuccess(data) {
        if (data.redirect_url) {
            window.location.href = data.redirect_url;
        } else {
            this.showOrderSummary(data);
        }
    }

    handleError(response) {
        if (response.status === 422) {
            response.json().then(errors => {
                this.showValidationErrors(errors.errors);
            });
        } else {
            this.showError(response.statusText || 'Terjadi kesalahan server');
        }
    }

    showValidationErrors(errors) {
        Object.keys(errors).forEach(field => {
            const input = this.form.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('is-invalid');
                const errorDiv = input.nextElementSibling || document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = errors[field][0];
                input.parentNode.appendChild(errorDiv);
            }
        });
    }

    showOrderSummary(data) {
        this.summaryContent.innerHTML = `
            <div class="alert alert-success">
                <h4>Pesanan Diterima!</h4>
                <p>${data.product_name} (${data.quantity}x)</p>
                <p>Total: ${data.total_price}</p>
                <img src="${data.img}" class="img-thumbnail mt-2" style="max-height: 150px;">
            </div>
            <a href="{{ route('home') }}" class="btn btn-outline-primary w-100 mt-3">
                Kembali ke Menu
            </a>
        `;
        
        this.form.classList.add('d-none');
        this.orderSummary.classList.remove('d-none');
    }

    showError(message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger mt-3';
        alertDiv.textContent = message;
        this.form.insertBefore(alertDiv, this.form.firstChild);
        
        setTimeout(() => alertDiv.remove(), 5000);
    }

    setLoading(isLoading) {
        if (isLoading) {
            this.submitText.classList.add('d-none');
            this.loadingSpinner.classList.remove('d-none');
            this.submitBtn.disabled = true;
        } else {
            this.submitText.classList.remove('d-none');
            this.loadingSpinner.classList.add('d-none');
            this.submitBtn.disabled = false;
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new OrderForm();
    

    const quantityInput = document.getElementById('quantity');
    const priceDisplay = document.getElementById('price-preview');
    
    if (quantityInput && priceDisplay) {
        quantityInput.addEventListener('input', function() {
            const price = parseFloat(quantityInput.dataset.unitPrice);
            const total = price * this.value;
            priceDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
        });
    }
});