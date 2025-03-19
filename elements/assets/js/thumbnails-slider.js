document.addEventListener("DOMContentLoaded", function () {
  const thumbnailsSliders = document.querySelectorAll(
    ".rony-thumbnails-slider-wrapper"
  );

  if (thumbnailsSliders.length > 0) {
    // Function to handle resizing for sliders
    const handleResize = () => {
      thumbnailsSliders.forEach(function (sliderWrapper) {
        const thumbnailsPosition =
          sliderWrapper.dataset.thumbnailsPosition || "bottom";
        const verticalThumbnailsWidth =
          parseInt(sliderWrapper.dataset.verticalThumbnailsWidth) || 120;

        // Only adjust for left/right layouts on larger screens
        if (
          (thumbnailsPosition === "left" || thumbnailsPosition === "right") &&
          window.innerWidth >= 768
        ) {
          const mainSliderElement = sliderWrapper.querySelector(".main-slider");
          mainSliderElement.style.width = `calc(100% - ${verticalThumbnailsWidth}px - 10px)`;
        } else if (window.innerWidth < 768) {
          // Reset to full width on mobile
          const mainSliderElement = sliderWrapper.querySelector(".main-slider");
          mainSliderElement.style.width = "100%";
        }
      });
    };

    // Add resize event listener
    window.addEventListener("resize", handleResize);

    // Initialize sliders
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
      const thumbnailsPosition =
        sliderWrapper.dataset.thumbnailsPosition || "bottom";
      const verticalThumbnailsWidth =
        parseInt(sliderWrapper.dataset.verticalThumbnailsWidth) || 120;

      // Get custom arrow icons
      const mainPrevArrow =
        sliderWrapper.dataset.mainPrevArrow ||
        '<i class="ion-chevron-left"></i>';
      const mainNextArrow =
        sliderWrapper.dataset.mainNextArrow ||
        '<i class="ion-chevron-right"></i>';
      const thumbnailsPrevArrow =
        sliderWrapper.dataset.thumbnailsPrevArrow ||
        '<i class="ion-chevron-left"></i>';
      const thumbnailsNextArrow =
        sliderWrapper.dataset.thumbnailsNextArrow ||
        '<i class="ion-chevron-right"></i>';

      // Set width for main slider in left/right position layouts
      if (thumbnailsPosition === "left" || thumbnailsPosition === "right") {
        // Set the CSS variable for vertical thumbnails width
        sliderWrapper.style.setProperty(
          "--vertical-thumbnails-width",
          `${verticalThumbnailsWidth}px`
        );

        // Make sure main slider takes full remaining width
        if (window.innerWidth >= 768) {
          const mainSliderElement = sliderWrapper.querySelector(".main-slider");
          mainSliderElement.style.width = `calc(100% - ${verticalThumbnailsWidth}px - 10px)`;
        }
      }

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
        // Custom arrows
        classes: {
          arrows: "splide__arrows main-slider-arrows",
          prev: "splide__arrow--prev main-slider-prev",
          next: "splide__arrow--next main-slider-next",
        },
      });

      // Custom arrow HTML for main slider
      if (showArrows) {
        // After initialization, customize the arrows
        mainSlider.on("mounted", function () {
          const prevArrow = sliderWrapper.querySelector(".main-slider-prev");
          const nextArrow = sliderWrapper.querySelector(".main-slider-next");

          if (prevArrow) {
            prevArrow.innerHTML = mainPrevArrow;
          }

          if (nextArrow) {
            nextArrow.innerHTML = mainNextArrow;
          }
        });
      }

      // Configure thumbnail slider based on position
      const thumbnailConfig = {
        rewind: true,
        pagination: false,
        arrows: thumbnailsArrows,
        isNavigation: true,
        gap: thumbnailsGap,
        cover: true,
        // Custom arrows
        classes: {
          arrows: "splide__arrows thumbnail-slider-arrows",
          prev: "splide__arrow--prev thumbnail-slider-prev",
          next: "splide__arrow--next thumbnail-slider-next",
        },
      };

      // Add position-specific settings
      if (thumbnailsPosition === "bottom") {
        Object.assign(thumbnailConfig, {
          fixedWidth: thumbnailsWidth,
          fixedHeight: thumbnailsHeight,
          perPage: thumbnailsPerPage,
          perMove: 1,
          direction: "ltr",
          breakpoints: {
            768: {
              fixedWidth: Math.max(60, thumbnailsWidth * 0.75),
              fixedHeight: Math.max(40, thumbnailsHeight * 0.75),
            },
          },
        });
      } else if (thumbnailsPosition === "left") {
        // For left vertical thumbnail sliders
        Object.assign(thumbnailConfig, {
          direction: "ttb",
          height: `${
            thumbnailsHeight * thumbnailsPerPage +
            (thumbnailsPerPage - 1) * thumbnailsGap
          }px`,
          fixedWidth: thumbnailsWidth,
          fixedHeight: thumbnailsHeight,
          perPage: thumbnailsPerPage,
          perMove: 1,
          breakpoints: {
            768: {
              direction: "ltr", // Switch to horizontal on mobile
              height: "auto",
              fixedWidth: Math.max(60, thumbnailsWidth * 0.75),
              fixedHeight: Math.max(40, thumbnailsHeight * 0.75),
            },
          },
        });
      } else if (thumbnailsPosition === "right") {
        // For right vertical thumbnail sliders
        Object.assign(thumbnailConfig, {
          direction: "ttb",
          height: `${
            thumbnailsHeight * thumbnailsPerPage +
            (thumbnailsPerPage - 1) * thumbnailsGap
          }px`,
          fixedWidth: thumbnailsWidth,
          fixedHeight: thumbnailsHeight,
          perPage: thumbnailsPerPage,
          perMove: 1,
          breakpoints: {
            768: {
              direction: "ltr", // Switch to horizontal on mobile
              height: "auto",
              fixedWidth: Math.max(60, thumbnailsWidth * 0.75),
              fixedHeight: Math.max(40, thumbnailsHeight * 0.75),
            },
          },
        });
      }

      // Initialize thumbnail slider with config
      const thumbnailSlider = new Splide(
        `#${thumbnailSliderId}`,
        thumbnailConfig
      );

      // Custom arrow HTML for thumbnail slider
      if (thumbnailsArrows) {
        // After initialization, customize the arrows
        thumbnailSlider.on("mounted", function () {
          const prevArrow = sliderWrapper.querySelector(
            ".thumbnail-slider-prev"
          );
          const nextArrow = sliderWrapper.querySelector(
            ".thumbnail-slider-next"
          );

          if (prevArrow) {
            prevArrow.innerHTML = thumbnailsPrevArrow;
          }

          if (nextArrow) {
            nextArrow.innerHTML = thumbnailsNextArrow;
          }
        });
      }

      // Sync the sliders
      mainSlider.sync(thumbnailSlider);

      // Mount the sliders
      mainSlider.mount();
      thumbnailSlider.mount();
    });

    // Call resize handler initially to set correct widths
    handleResize();
  }
});
