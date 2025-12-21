document.addEventListener('DOMContentLoaded', function () {
    const flashMessages = document.querySelectorAll('[role="alert"]');
    flashMessages.forEach(function (msg) {
        setTimeout(function () {
            msg.style.transition = 'opacity 0.5s ease-out';
            msg.style.opacity = '0';
            setTimeout(function () {
                msg.remove();
            }, 500);
        }, 5000);
    });

    const numberInputs = document.querySelectorAll('input[type="number"]');
    numberInputs.forEach(function (input) {
        input.addEventListener('blur', function () {
            if (this.value && parseFloat(this.value) < 0) {
                this.value = 0;
            }
        });
    });

    const deleteForms = document.querySelectorAll('form[data-confirm]');
    deleteForms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!confirm(this.dataset.confirm || 'Apakah Anda yakin?')) {
                e.preventDefault();
            }
        });
    });
});

function formatRupiah(amount) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
}
