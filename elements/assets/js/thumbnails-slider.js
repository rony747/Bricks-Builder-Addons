document.addEventListener("DOMContentLoaded", function () {
  const thumbnailsSliders = document.querySelectorAll(
    ".rony-thumbnails-slider-wrapper"
  );

  if (thumbnailsSliders.length > 0) {
    thumbnailsSliders.forEach(function (sliderWrapper, index) {
      // Get slider settings from data attributes
      const sliderType = sliderWrapper.dataset.sliderType || "fade";
      const showArrows = sliderWrapper.dataset.showArrows === "true";
      const showPagination = sliderWrapper.dataset.showPagination === "true";
      const autoplay = sliderWrapper.dataset.autoplay === "true";
      const autoplayInterval =
        parseInt(sliderWrapper.dataset.autoplayInterval) || 5000;
      const thumbnailsPerPage =
        parseInt(sliderWrapper.dataset.thumbnailsPerPage) || 5;
      const thumbnailsSpacing =
        parseInt(sliderWrapper.dataset.thumbnailsSpacing) || 10;
      const thumbnailsWidth =
        parseInt(sliderWrapper.dataset.thumbnailsWidth) || 100;
      const thumbnailsHeight =
        parseInt(sliderWrapper.dataset.thumbnailsHeight) || 60;
      const thumbnailsGap = parseInt(sliderWrapper.dataset.thumbnailsGap) || 10;
      const thumbnailsArrows =
        sliderWrapper.dataset.thumbnailsArrows === "true";

      // Unique IDs for this slider instance
      const mainSliderId = `main-slider-${index}`;
      const thumbnailSliderId = `thumbnail-slider-${index}`;

      // Update IDs
      sliderWrapper.querySelector(".main-slider").id = mainSliderId;
      sliderWrapper.querySelector(".thumbnail-slider").id = thumbnailSliderId;

      // Initialize main slider
      const mainSlider = new Splide(`#${mainSliderId}`, {
        type: sliderType,
        rewind: true,
        pagination: showPagination,
        arrows: showArrows,
        autoplay: autoplay,
        interval: autoplayInterval,
      });

      // Initialize thumbnail slider
      const thumbnailSlider = new Splide(`#${thumbnailSliderId}`, {
        fixedWidth: thumbnailsWidth,
        fixedHeight: thumbnailsHeight,
        gap: thumbnailsGap,
        rewind: true,
        pagination: false,
        arrows: thumbnailsArrows,
        perPage: thumbnailsPerPage,
        perMove: 1,
        isNavigation: true,
        cover: true,
        breakpoints: {
          768: {
            fixedWidth: Math.max(60, thumbnailsWidth * 0.75),
            fixedHeight: Math.max(40, thumbnailsHeight * 0.75),
          },
        },
      });

      // Sync the sliders
      mainSlider.sync(thumbnailSlider);

      // Mount the sliders
      mainSlider.mount();
      thumbnailSlider.mount();
    });
  }
});
