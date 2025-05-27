document.addEventListener("DOMContentLoaded", () => {
  const header = document.querySelector("header"),
      openMenu = document.getElementById("openMenu"),
      closeMenu = document.getElementById("closeMenu"),
      menu = document.getElementById("menu"),
      body = document.body,
      btnToggle = document.querySelector(".repair-btn button"),
      wrapper = document.querySelector(".repair-slider"),
      swiperWrapper = wrapper?.querySelector(".swiper-wrapper"),
      servicesOpen = document.querySelector(".services__btn button"),
      servicesItems = document.querySelector(".services__items"),
      tabs = document.querySelectorAll(".price__tab"),
      contents = document.querySelectorAll("[data-tab-content]"),
      modal = document.querySelector(".feedback-modal"),
      promotionWrapper = document.querySelector(".promotionSwiper .swiper-wrapper"),
      originalHTML = promotionWrapper?.innerHTML || "";

  let expanded = false,
      service = false,
      repairSwiper = wrapper ? initRepairSwiper() : null,
      promotionSwiper;

  function initRepairSwiper() {
    return new Swiper(".repair-slider", {
      navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
      pagination: { el: ".swiper-pagination" },
    });
  }

  function initPromotionSwiper() {
    if (promotionSwiper) promotionSwiper.destroy(true, true);
    promotionSwiper = new Swiper(".promotionSwiper", {
      slidesPerView: 2,
      spaceBetween: 16,
      centeredSlides: true,
      pagination: { el: ".swiper-pagination", clickable: true },
      navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
      breakpoints: { 991: { slidesPerView: "auto", spaceBetween: 30 }, 768: { slidesPerView: 2, spaceBetween: 16 }, 375: { slidesPerView: 1, spaceBetween: 16 } },
    });
  }

  const restructureSlidesForMobile = () => {
    if (!promotionWrapper) return;
    const items = Array.from(promotionWrapper.querySelectorAll(".promotion__item"));
    promotionWrapper.innerHTML = "";
    items.forEach(i => {
      const slide = document.createElement("div");
      slide.className = "swiper-slide";
      slide.appendChild(i.cloneNode(true));
      promotionWrapper.appendChild(slide);
    });
  };

  const restoreOriginalSlides = () => {
    if (!promotionWrapper) return;
    promotionWrapper.innerHTML = originalHTML;
  };

  const handleResize = () => {
    if (!promotionWrapper) return;
    if (window.innerWidth <= 991) {
      restructureSlidesForMobile();
    } else {
      restoreOriginalSlides();
    }
    initPromotionSwiper();
  };

  window.addEventListener("scroll", () => {
    if (header) header.classList.toggle("scrolled", window.scrollY > 0);
  });

  openMenu?.addEventListener("click", () => {
    menu?.classList.add("open");
    body.classList.add("shadow");
  });

  closeMenu?.addEventListener("click", () => {
    menu?.classList.remove("open");
    body.classList.remove("shadow");
  });

  btnToggle?.addEventListener("click", () => {
    if (!wrapper) return;
    expanded = !expanded;
    if (expanded) {
      repairSwiper?.destroy(true, true);
      wrapper.classList.add("expanded");
      btnToggle.textContent = "Скрыть";
    } else {
      repairSwiper = initRepairSwiper();
      wrapper.classList.remove("expanded");
      btnToggle.textContent = "Показать все";
    }
  });

  servicesOpen?.addEventListener("click", () => {
    if (!servicesItems) return;
    service = !service;
    servicesItems.classList.toggle("service", service);
    servicesOpen.textContent = service ? "Скрыть" : "Показать все";
  });

  new Swiper(".aboutSwiper", {
    pagination: { el: ".swiper-pagination", type: "fraction" },
    navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
  });

  new Swiper(".sertSwiper", {
    slidesPerView: 3,
    spaceBetween: 16,
    pagination: { el: ".swiper-pagination" },
    navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
    breakpoints: { 991: { slidesPerView: 3, spaceBetween: 15 }, 768: { slidesPerView: 2, spaceBetween: 15 }, 576: { slidesPerView: 2, spaceBetween: 10 }, 400: { slidesPerView: 2, spaceBetween: 10 }, 375: { slidesPerView: 1, spaceBetween: 10 } },
  });

  tabs.forEach(tab => {
    tab.addEventListener("click", () => {
      const target = tab.dataset.tab;
      tabs.forEach(t => t.classList.remove("active"));
      tab.classList.add("active");
      contents.forEach(c => c.style.display = c.dataset.tabContent === target ? "flex" : "none");
    });
  });
  tabs[0]?.click();

  document.addEventListener("click", e => {
    const button = e.target.closest(".open-form-btn");
    if (button) {
      modal?.classList.add("active");
      body.classList.add("lock");
    }
    if (modal && e.target === modal) {
      modal.classList.remove("active");
      body.classList.remove("lock");
    }
  });

  if (window.jQuery) $(".phone").mask("+7(999) 999-99-99");

  window.addEventListener("resize", handleResize);
  handleResize();
});
