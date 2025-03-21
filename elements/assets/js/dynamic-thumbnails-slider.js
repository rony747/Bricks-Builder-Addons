document.addEventListener("DOMContentLoaded", function () {
  console.log("Dynamic Thumbnails Slider JS loaded");

  const dynamicThumbnailsSliders = document.querySelectorAll(
    ".rony-dynamic-thumbnails-slider-wrapper"
  );

  if (dynamicThumbnailsSliders.length > 0) {
    console.log(
      `Found ${dynamicThumbnailsSliders.length} dynamic thumbnails sliders`
    );

    // Function to handle resizing for sliders
    const handleResize = () => {
      dynamicThumbnailsSliders.forEach(function (sliderWrapper) {
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

    dynamicThumbnailsSliders.forEach(function (sliderWrapper, index) {
      console.log(`Initializing dynamic thumbnails slider #${index}`);

      // Debug slider arrows
      const mainArrows = sliderWrapper.querySelectorAll(
        ".rony-main-slider .splide__arrow"
      );
      console.log(`Main slider arrows found: ${mainArrows.length}`);

      const thumbArrows = sliderWrapper.querySelectorAll(
        ".rony-thumbnail-slider .splide__arrow"
      );
      console.log(`Thumbnail slider arrows found: ${thumbArrows.length}`);

      // Setup slider elements and IDs
      const mainSliderElement = sliderWrapper.querySelector(".main-slider");
      const thumbnailSliderElement =
        sliderWrapper.querySelector(".thumbnail-slider");

      if (!mainSliderElement || !thumbnailSliderElement) {
        console.log(
          "Main slider or thumbnail slider not found",
          mainSliderElement,
          thumbnailSliderElement
        );
        return;
      }

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

      console.log("Slider settings:", {
        sliderType,
        showArrows,
        thumbnailsArrows,
        thumbnailsPosition,
        thumbnailsPerPage,
      });

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
        pagination: showPagination,
        arrows: showArrows,
        autoplay: autoplay,
        interval: autoplayInterval,
      });

      // Configure thumbnail slider
      const thumbnailConfig = {
        rewind: true,
        pagination: false,
        arrows: thumbnailsArrows,
        isNavigation: true,
        gap: thumbnailsGap,
        cover: true,
      };

      // Position-specific settings
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
      } else if (
        thumbnailsPosition === "left" ||
        thumbnailsPosition === "right"
      ) {
        const heightVal = thumbnailsHeight;
        const perPageVal = thumbnailsPerPage;
        const gapVal = thumbnailsGap;

        Object.assign(thumbnailConfig, {
          direction: "ttb",
          height: `${heightVal * perPageVal + (perPageVal - 1) * gapVal}px`,
          fixedWidth: thumbnailsWidth,
          fixedHeight: heightVal,
          perPage: perPageVal,
          perMove: 1,
          breakpoints: {
            768: {
              direction: "ltr",
              height: "auto",
              fixedWidth: Math.max(60, thumbnailsWidth * 0.75),
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
  } else {
    console.log("No dynamic thumbnails sliders found on page");
  }
});
