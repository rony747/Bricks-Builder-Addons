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
        const verticalThumbnailsWidth = parseInt(
          sliderWrapper.dataset.verticalThumbnailsWidth
        );

        // Only adjust for left/right layouts on larger screens
        if (
          (thumbnailsPosition === "left" || thumbnailsPosition === "right") &&
          window.innerWidth >= 768
        ) {
          const mainSliderElement =
            sliderWrapper.querySelector(".rony-main-slider");
          mainSliderElement.style.width = `calc(100% - ${verticalThumbnailsWidth}px - 10px)`;
        } else if (window.innerWidth < 768) {
          // Reset to full width on mobile
          const mainSliderElement =
            sliderWrapper.querySelector(".rony-main-slider");
          mainSliderElement.style.width = "100%";
        }
      });
    };

    // Add resize event listener
    window.addEventListener("resize", handleResize);

    // Initialize sliders
    thumbnailsSliders.forEach(function (sliderWrapper, index) {
      // Get slider settings from data attributes
      const sliderType = sliderWrapper.dataset.sliderType;
      const showArrows = sliderWrapper.dataset.showArrows === "true";
      const showPagination = sliderWrapper.dataset.showPagination === "true";
      const autoplay = sliderWrapper.dataset.autoplay === "true";
      const autoplayInterval = parseInt(sliderWrapper.dataset.autoplayInterval);
      const thumbnailsPerPage = parseInt(
        sliderWrapper.dataset.thumbnailsPerPage
      );
      const thumbnailsSpacing = parseInt(
        sliderWrapper.dataset.thumbnailsSpacing
      );
      const thumbnailsWidth = parseInt(sliderWrapper.dataset.thumbnailsWidth);
      const thumbnailsHeight = parseInt(sliderWrapper.dataset.thumbnailsHeight);
      const thumbnailsGap = parseInt(sliderWrapper.dataset.thumbnailsGap);
      const thumbnailsArrows =
        sliderWrapper.dataset.thumbnailsArrows === "true";
      const thumbnailsPosition = sliderWrapper.dataset.thumbnailsPosition;
      const verticalThumbnailsWidth = parseInt(
        sliderWrapper.dataset.verticalThumbnailsWidth
      );

      // Get custom arrow icons
      const mainPrevArrow = sliderWrapper.dataset.mainPrevArrow;
      const mainNextArrow = sliderWrapper.dataset.mainNextArrow;
      const thumbnailsPrevArrow = sliderWrapper.dataset.thumbnailsPrevArrow;
      const thumbnailsNextArrow = sliderWrapper.dataset.thumbnailsNextArrow;

      // Set width for main slider in left/right position layouts
      if (thumbnailsPosition === "left" || thumbnailsPosition === "right") {
        // Set the CSS variable for vertical thumbnails width
        sliderWrapper.style.setProperty(
          "--vertical-thumbnails-width",
          `${verticalThumbnailsWidth}px`
        );

        // Make sure main slider takes full remaining width
        if (window.innerWidth >= 768) {
          const mainSliderElement =
            sliderWrapper.querySelector(".rony-main-slider");
          mainSliderElement.style.width = `calc(100% - ${verticalThumbnailsWidth}px - 10px)`;
        }
      }

      // Unique IDs for this slider instance
      const mainSliderId = `rony-main-slider-${index}`;
      const thumbnailSliderId = `rony-thumbnail-slider-${index}`;

      // Update IDs
      sliderWrapper.querySelector(".main-slider").id = mainSliderId;
      sliderWrapper.querySelector(".thumbnail-slider").id = thumbnailSliderId;

      // Update classes
      sliderWrapper
        .querySelector(".main-slider")
        .classList.add("rony-main-slider");
      sliderWrapper
        .querySelector(".thumbnail-slider")
        .classList.add("rony-thumbnail-slider");

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
          arrows: "splide__arrows rony-main-slider-arrows",
          prev: "splide__arrow--prev rony-main-slider-prev",
          next: "splide__arrow--next rony-main-slider-next",
        },
      });

      // Custom arrow HTML for main slider
      if (showArrows) {
        // After initialization, customize the arrows
        mainSlider.on("mounted", function () {
          const prevArrow = sliderWrapper.querySelector(
            ".rony-main-slider-prev"
          );
          const nextArrow = sliderWrapper.querySelector(
            ".rony-main-slider-next"
          );

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
          arrows: "splide__arrows rony-thumbnail-slider-arrows",
          prev: "splide__arrow--prev rony-thumbnail-slider-prev",
          next: "splide__arrow--next rony-thumbnail-slider-next",
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
            ".rony-thumbnail-slider-prev"
          );
          const nextArrow = sliderWrapper.querySelector(
            ".rony-thumbnail-slider-next"
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
