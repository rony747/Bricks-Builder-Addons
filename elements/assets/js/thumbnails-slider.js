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

        if (
          (thumbnailsPosition === "left" || thumbnailsPosition === "right") &&
          window.innerWidth >= 768
        ) {
          const mainSliderElement =
            sliderWrapper.querySelector(".rony-main-slider");
          if (mainSliderElement) {
            mainSliderElement.style.width = `calc(100% - ${verticalThumbnailsWidth}px - 10px)`;
          }
        } else if (window.innerWidth < 768) {
          const mainSliderElement =
            sliderWrapper.querySelector(".rony-main-slider");
          if (mainSliderElement) {
            mainSliderElement.style.width = "100%";
          }
        }
      });
    };

    // Add resize event listener
    window.addEventListener("resize", handleResize);

    thumbnailsSliders.forEach(function (sliderWrapper, index) {
      // Setup slider elements and IDs
      const mainSliderElement = sliderWrapper.querySelector(".main-slider");
      const thumbnailSliderElement =
        sliderWrapper.querySelector(".thumbnail-slider");

      if (!mainSliderElement || !thumbnailSliderElement) return;

      // Add rony prefix classes
      mainSliderElement.classList.add("rony-main-slider");
      thumbnailSliderElement.classList.add("rony-thumbnail-slider");

      // Unique IDs for this slider instance
      const mainSliderId = `rony-main-slider-${index}`;
      const thumbnailSliderId = `rony-thumbnail-slider-${index}`;

      // Update element IDs
      mainSliderElement.id = mainSliderId;
      thumbnailSliderElement.id = thumbnailSliderId;

      // Get slider settings from data attributes
      const {
        sliderType = "fade",
        showArrows = "true",
        showPagination = "false",
        autoplay = "false",
        autoplayInterval = "5000",
        thumbnailsPerPage = "5",
        thumbnailsSpacing = "10",
        thumbnailsWidth = "100",
        thumbnailsHeight = "60",
        thumbnailsGap = "10",
        thumbnailsArrows = "true",
        thumbnailsPosition = "bottom",
        verticalThumbnailsWidth = "120",
      } = sliderWrapper.dataset;

      // Set CSS variable for thumbnail width
      if (thumbnailsPosition === "left" || thumbnailsPosition === "right") {
        sliderWrapper.style.setProperty(
          "--vertical-thumbnails-width",
          `${verticalThumbnailsWidth}px`
        );
      }

      // Initialize main slider with simplified options
      const mainSlider = new Splide(`#${mainSliderId}`, {
        type: sliderType,
        rewind: true,
        pagination: showPagination === "true",
        arrows: showArrows === "true",
        autoplay: autoplay === "true",
        interval: parseInt(autoplayInterval) || 5000,
      });

      // Configure thumbnail slider
      const thumbnailConfig = {
        rewind: true,
        pagination: false,
        arrows: thumbnailsArrows === "true",
        isNavigation: true,
        gap: parseInt(thumbnailsGap) || 10,
        cover: true,
      };

      // Position-specific settings
      if (thumbnailsPosition === "bottom") {
        Object.assign(thumbnailConfig, {
          fixedWidth: parseInt(thumbnailsWidth) || 100,
          fixedHeight: parseInt(thumbnailsHeight) || 60,
          perPage: parseInt(thumbnailsPerPage) || 5,
          perMove: 1,
          direction: "ltr",
          breakpoints: {
            768: {
              fixedWidth: Math.max(
                60,
                (parseInt(thumbnailsWidth) || 100) * 0.75
              ),
              fixedHeight: Math.max(
                40,
                (parseInt(thumbnailsHeight) || 60) * 0.75
              ),
            },
          },
        });
      } else if (
        thumbnailsPosition === "left" ||
        thumbnailsPosition === "right"
      ) {
        const heightVal = parseInt(thumbnailsHeight) || 60;
        const perPageVal = parseInt(thumbnailsPerPage) || 5;
        const gapVal = parseInt(thumbnailsGap) || 10;

        Object.assign(thumbnailConfig, {
          direction: "ttb",
          height: `${heightVal * perPageVal + (perPageVal - 1) * gapVal}px`,
          fixedWidth: parseInt(thumbnailsWidth) || 100,
          fixedHeight: heightVal,
          perPage: perPageVal,
          perMove: 1,
          breakpoints: {
            768: {
              direction: "ltr",
              height: "auto",
              fixedWidth: Math.max(
                60,
                (parseInt(thumbnailsWidth) || 100) * 0.75
              ),
              fixedHeight: Math.max(40, heightVal * 0.75),
            },
          },
        });
      }

      // Initialize thumbnail slider
      const thumbnailSlider = new Splide(
        `#${thumbnailSliderId}`,
        thumbnailConfig
      );

      // Sync sliders and mount
      mainSlider.sync(thumbnailSlider);
      mainSlider.mount();
      thumbnailSlider.mount();
    });

    // Initial resize
    handleResize();
  }
});
