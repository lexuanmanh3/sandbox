document.addEventListener("DOMContentLoaded", () => {
  // =========================================================================
  // Menu mobile (hamburger)
  // =========================================================================
  const menuToggle = document.querySelector(".menu-toggle");
  const navMenu    = document.querySelector("#mainMenu");
  const serviceItems = document.querySelectorAll(".service-item");
  const navLinks     = document.querySelectorAll(".nav-link");

  if (menuToggle && navMenu) {
    menuToggle.addEventListener("click", () => {
      const isOpen = navMenu.classList.toggle("show");
      menuToggle.setAttribute("aria-expanded", String(isOpen));
    });
  }

  serviceItems.forEach((item) => {
    item.addEventListener("click", () => {
      serviceItems.forEach((s) => s.classList.remove("active"));
      item.classList.add("active");
    });
  });

  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      navLinks.forEach((l) => l.classList.remove("active"));
      link.classList.add("active");

      if (navMenu?.classList.contains("show")) {
        navMenu.classList.remove("show");
        menuToggle?.setAttribute("aria-expanded", "false");
      }
    });
  });

  // =========================================================================
  // User dropdown — menu tài khoản cấp 2
  // =========================================================================
  const dropdown     = document.getElementById("userDropdown");
  const accountBtn   = document.getElementById("accountBtn");
  const accountMenu  = document.getElementById("accountMenu");
  const logoutBtn    = document.getElementById("logoutBtn");
  const logoutForm   = document.getElementById("logoutForm");

  // Tạo overlay trong suốt để bắt click ngoài menu
  const backdrop = document.createElement("div");
  backdrop.className = "dropdown-backdrop";
  document.body.appendChild(backdrop);

  /** Mở dropdown */
  function openDropdown() {
    dropdown.classList.add("is-open");
    accountMenu.classList.add("is-open");
    backdrop.classList.add("is-open");
    accountBtn.setAttribute("aria-expanded", "true");
    accountMenu.setAttribute("aria-hidden", "false");
  }

  /** Đóng dropdown */
  function closeDropdown() {
    dropdown.classList.remove("is-open");
    accountMenu.classList.remove("is-open");
    backdrop.classList.remove("is-open");
    accountBtn.setAttribute("aria-expanded", "false");
    accountMenu.setAttribute("aria-hidden", "true");
  }

  if (accountBtn && accountMenu) {
    // Toggle khi nhấn nút tài khoản
    accountBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.contains("is-open") ? closeDropdown() : openDropdown();
    });

    // Đóng khi nhấn ra ngoài (qua backdrop)
    backdrop.addEventListener("click", closeDropdown);

    // Đóng khi nhấn phím Escape
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && dropdown.classList.contains("is-open")) {
        closeDropdown();
        accountBtn.focus();
      }
    });

    // Điều hướng bàn phím trong menu (ArrowUp / ArrowDown)
    accountMenu.addEventListener("keydown", (e) => {
      const items = [...accountMenu.querySelectorAll(".dropdown-item")];
      const idx   = items.indexOf(document.activeElement);

      if (e.key === "ArrowDown") {
        e.preventDefault();
        items[(idx + 1) % items.length]?.focus();
      } else if (e.key === "ArrowUp") {
        e.preventDefault();
        items[(idx - 1 + items.length) % items.length]?.focus();
      }
    });
  }

  // =========================================================================
  // Logout — click thẳng, không cần xác nhận
  // =========================================================================
  if (logoutBtn && logoutForm) {
    logoutBtn.addEventListener("click", () => {
      logoutBtn.disabled = true;
      logoutBtn.innerHTML = `
        <svg class="icon animate-spin" aria-hidden="true" focusable="false" fill="currentColor">
          <use href="#icon-progress_activity" xlink:href="#icon-progress_activity"></use>
        </svg>
        Đang đăng xuất...
      `;
      logoutForm.submit();
    });
  }
});
