/* ==========================================================================
   Auth Login — JavaScript
   ========================================================================== */

/**
 * Bật/tắt hiển thị mật khẩu.
 */
function togglePassword() {
    const input    = document.getElementById('password');
    const iconShow = document.getElementById('passwordIconShow');
    const iconHide = document.getElementById('passwordIconHide');

    if (input.type === 'password') {
        input.type             = 'text';
        iconShow.style.display = 'none';
        iconHide.style.display = '';
    } else {
        input.type             = 'password';
        iconShow.style.display = '';
        iconHide.style.display = 'none';
    }
}

/**
 * Hiệu ứng xuất hiện lần lượt cho từng phần tử trong form.
 */
document.addEventListener('DOMContentLoaded', () => {
    const formElements = document.querySelectorAll('#loginForm > div');

    formElements.forEach((el, index) => {
        el.style.opacity   = '0';
        el.style.transform = 'translateY(10px)';

        setTimeout(() => {
            el.style.transition = 'all 0.4s ease-out';
            el.style.opacity    = '1';
            el.style.transform  = 'translateY(0)';
        }, 150 + index * 100);
    });
});

/**
 * Hiệu ứng loading khi submit form.
 * Không ngăn form submit thật — chỉ đổi nội dung nút để UX mượt hơn.
 */
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    if (!form) return;

    form.addEventListener('submit', (e) => {
        const btn = form.querySelector('button[type="submit"]');
        if (!btn) return;

        // Hiển thị trạng thái loading, vô hiệu hoá nút tránh double-submit
        btn.disabled   = true;
        btn.classList.add('btn-loading');
        btn.innerHTML  = `
            <svg class="icon animate-spin" aria-hidden="true" focusable="false" fill="currentColor">
                <use href="#icon-progress_activity" xlink:href="#icon-progress_activity"></use>
            </svg>
            <span>Đang xác thực...</span>
        `;

        // Để form tự submit bình thường lên server (không preventDefault)
    });
});
