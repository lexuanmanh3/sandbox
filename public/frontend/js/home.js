document.addEventListener("DOMContentLoaded", () => {
  const menuToggle = document.querySelector(".menu-toggle");
  const navMenu = document.querySelector("#mainMenu");
  const serviceItems = document.querySelectorAll(".service-item");
  const navLinks = document.querySelectorAll(".nav-link");

  if (menuToggle && navMenu) {
    menuToggle.addEventListener("click", () => {
      const isOpen = navMenu.classList.toggle("show");
      menuToggle.setAttribute("aria-expanded", String(isOpen));
      menuToggle.querySelector(".material-symbols-outlined").textContent = isOpen ? "close" : "menu";
    });
  }

  serviceItems.forEach((item) => {
    item.addEventListener("click", () => {
      serviceItems.forEach((service) => service.classList.remove("active"));
      item.classList.add("active");
    });
  });

  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      navLinks.forEach((navLink) => navLink.classList.remove("active"));
      link.classList.add("active");

      if (navMenu?.classList.contains("show")) {
        navMenu.classList.remove("show");
        menuToggle?.setAttribute("aria-expanded", "false");
        const icon = menuToggle?.querySelector(".material-symbols-outlined");
        if (icon) icon.textContent = "menu";
      }
    });
  });
});
