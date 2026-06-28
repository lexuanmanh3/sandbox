document.addEventListener("DOMContentLoaded", () => {
  const filterToggle = document.querySelector("[data-account-filter-toggle]");
  const filter = document.querySelector("[data-account-filter]");
  const searchInput = document.querySelector("[data-account-search]");
  const rows = [...document.querySelectorAll("[data-account-row]")];

  filterToggle?.addEventListener("click", () => {
    const isOpen = filterToggle.getAttribute("aria-expanded") === "true";
    const section = filterToggle.closest(".account-filter-section");
    filterToggle.setAttribute("aria-expanded", String(!isOpen));
    section?.classList.toggle("is-open", !isOpen);
    if (filter) {
      filter.hidden = isOpen;
    }
  });

  filter?.addEventListener("submit", (event) => {
    event.preventDefault();
  });

  searchInput?.addEventListener("input", () => {
    const keyword = searchInput.value.trim().toLowerCase();

    rows.forEach((row) => {
      const username = row.querySelector(".account-username")?.textContent.toLowerCase() || "";
      row.hidden = keyword !== "" && !username.includes(keyword);
    });
  });

  rows.forEach((row) => {
    row.addEventListener("click", (event) => {
      if (event.target.closest(".account-row-actions")) return;

      rows.forEach((item) => item.classList.remove("is-selected"));
      row.classList.add("is-selected");
    });
  });

  document.querySelectorAll("[data-row-action]").forEach((button) => {
    button.addEventListener("click", (event) => {
      event.stopPropagation();

      const wrapper = button.closest(".account-row-actions");
      const menu = wrapper?.querySelector(".account-row-menu");
      if (!wrapper || !menu) return;

      document.querySelectorAll(".account-row-actions.is-open").forEach((openWrapper) => {
        if (openWrapper === wrapper) return;
        openWrapper.classList.remove("is-open");
        openWrapper.querySelector(".account-row-menu")?.setAttribute("hidden", "");
      });

      const isOpen = wrapper.classList.toggle("is-open");
      menu.hidden = !isOpen;

      if (isOpen) {
        const rect = button.getBoundingClientRect();
        menu.style.left = `${rect.left}px`;
        menu.style.top = `${rect.bottom + 6}px`;
      }
    });
  });

  document.addEventListener("click", () => {
    document.querySelectorAll(".account-row-actions.is-open").forEach((wrapper) => {
      wrapper.classList.remove("is-open");
      wrapper.querySelector(".account-row-menu")?.setAttribute("hidden", "");
    });
  });
});
