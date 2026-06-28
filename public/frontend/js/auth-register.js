document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("registerForm");
  const fullNameInput = document.getElementById("full_name");
  const lastNameInput = document.getElementById("ho");
  const firstNameInput = document.getElementById("ten");

  function syncNameParts() {
    if (!fullNameInput || !lastNameInput || !firstNameInput) return;

    const parts = fullNameInput.value.trim().replace(/\s+/g, " ").split(" ").filter(Boolean);

    if (parts.length === 0) {
      lastNameInput.value = "";
      firstNameInput.value = "";
      return;
    }

    if (parts.length === 1) {
      lastNameInput.value = parts[0];
      firstNameInput.value = parts[0];
      return;
    }

    firstNameInput.value = parts.pop();
    lastNameInput.value = parts.join(" ");
  }

  fullNameInput?.addEventListener("input", syncNameParts);
  syncNameParts();

  document.querySelectorAll("[data-toggle-password]").forEach((button) => {
    button.addEventListener("click", () => {
      const input = document.getElementById(button.dataset.togglePassword);
      if (!input) return;

      const isVisible = input.type === "text";
      input.type = isVisible ? "password" : "text";
      button.classList.toggle("is-visible", !isVisible);
      button.setAttribute("aria-label", isVisible ? "Hiện mật khẩu" : "Ẩn mật khẩu");
    });
  });

  form?.addEventListener("submit", () => {
    syncNameParts();

    const submitButton = form.querySelector(".register-submit");
    if (!submitButton) return;

    submitButton.disabled = true;
    submitButton.innerHTML = `
      <svg class="icon animate-spin" aria-hidden="true" focusable="false" fill="currentColor">
        <use href="#icon-progress_activity" xlink:href="#icon-progress_activity"></use>
      </svg>
      <span>Đang tạo tài khoản...</span>
    `;
  });
});
