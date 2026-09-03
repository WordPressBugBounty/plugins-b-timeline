jQuery(document).ready(function ($) {
  const MOBILE_BREAKPOINT = 600;

  const isMobile = () => window.innerWidth <= MOBILE_BREAKPOINT;

  const toInt = (value, fallback) => {
    const parsed = parseInt(value, 10);
    return isNaN(parsed) ? fallback : parsed;
  };

  // The timeline library only accepts top/bottom for horizontal mode and
  // left/right for vertical mode. Passing the raw setting to both of them
  // makes it warn and silently fall back to its own default.
  const toHorizontalPosition = (location) =>
    location === "bottom" ? "bottom" : "top";
  const toVerticalPosition = (location) =>
    location === "right" ? "right" : "left";

  const highestOf = (items) =>
    Array.from(items).reduce(
      (highest, item) => Math.max(highest, item.getBoundingClientRect().height),
      0
    );

  const clearStyles = (el, properties) => {
    if (!el) return;
    properties.forEach((property) => el.style.removeProperty(property));
  };

  // The library re-renders on resize and only resets `.timeline__item` /
  // `.timeline__items`, so the inline styles added below have to be cleaned up
  // by hand before the vertical / mobile layout can be trusted.
  const resetHorizontalStyles = (el) => {
    clearStyles(el.querySelector(".timeline__items"), ["height"]);

    el.querySelectorAll(".timeline__items .timeline__item").forEach((item) => {
      clearStyles(item, [
        "height",
        "transform",
        "-webkit-transform",
        "-ms-transform",
      ]);
    });

    el.querySelectorAll(".timeline__item__inner").forEach((inner) => {
      clearStyles(inner, ["display", "align-items"]);
    });

    el.querySelectorAll(".timeline__content__wrap").forEach((wrap) => {
      clearStyles(wrap, ["display", "width", "margin", "max-width"]);
    });
  };

  const maintainContentPosition = (el, mode, position, labelLocation) => {
    const itemsContainer = el.querySelector(`.timeline__items`);
    const allTimelineItem = el.querySelectorAll(
      `.timeline__items .timeline__item`
    );
    const allTimelineNavButton = el.querySelectorAll(`.timeline-nav-button`);
    const timelineDivider = el.querySelector(`.timeline-divider`);

    // Below the breakpoint the library always renders vertically, no matter
    // what the shortcode asked for. `.timeline-divider` and the nav buttons
    // only exist in a horizontal render, so the horizontal branch below must
    // never run here.
    const renderedMode =
      mode === "horizontal" && !isMobile() ? "horizontal" : "vertical";

    if (renderedMode === "vertical") {
      resetHorizontalStyles(el);
    }

    allTimelineItem?.forEach((item, index) => {
      if (renderedMode === "horizontal") {
        if (position === "end") {
          if (item.classList.contains("timeline__item--top")) {
            item.classList.remove("timeline__item--top");
            item.classList.add("timeline__item--bottom");
          }
          item.style.transform = "translateY(20px)";
          allTimelineNavButton.forEach((btn) => {
            btn.style.top = "20px";
          });
          if (timelineDivider) {
            timelineDivider.style.top = "20px";
          }
          if (itemsContainer) {
            itemsContainer.style.height = `${
              item.getBoundingClientRect().height + 20
            }px`;
          }
          const inner = item.querySelectorAll(".timeline__item__inner");
          inner.forEach((inner) => {
            inner.style.display = "flex";
            inner.style.alignItems = "start";
          });
          const contentWrap = item.querySelectorAll(".timeline__content__wrap");
          contentWrap.forEach((inner) => {
            inner.style.display = "block";
            inner.style.width = "fit-content";
            inner.style.margin = "0 auto";
            inner.style.maxWidth = "100%";
          });
        } else if (position === "start") {
          if (item.classList.contains("timeline__item--bottom")) {
            item.classList.remove("timeline__item--bottom");
            item.classList.add("timeline__item--top");
          }
          item.style.transform = "unset";

          const inner = item.querySelectorAll(".timeline__item__inner");
          inner.forEach((inner) => {
            inner.style.display = "flex";
            inner.style.alignItems = "end";
          });
          const contentWrap = item.querySelectorAll(".timeline__content__wrap");
          contentWrap.forEach((inner) => {
            inner.style.display = "block";
            inner.style.width = "fit-content";
            inner.style.margin = "0 auto";
            inner.style.maxWidth = "100%";
          });

          allTimelineNavButton.forEach((btn) => {
            btn.style.top = "calc(100% - 15px)";
          });
          if (timelineDivider) {
            timelineDivider.style.top = `${item.clientHeight}px`;
          }
          if (itemsContainer) {
            itemsContainer.style.height = `${
              item.getBoundingClientRect().height + 20
            }px`;
          }
        } else {
          if (labelLocation == "top") {
            if (index % 2 == 0) {
              item.classList.remove("timeline__item--bottom");
              item.classList.add("timeline__item--top");
            } else {
              item.classList.remove("timeline__item--top");
              item.classList.add("timeline__item--bottom");
            }
            // Fix: Ensure rendering is complete before measuring heights
            setTimeout(() => {
              const bottomItems = el.querySelectorAll(".timeline__item--bottom");
              bottomItems.forEach((item) => {
                item.style.height = "fit-content";
              });
              const bottomItemHighest = highestOf(bottomItems);

              const topItems = el.querySelectorAll(".timeline__item--top");
              const topItemsHighest = highestOf(topItems);

              if (itemsContainer) {
                itemsContainer.style.height = `${
                  bottomItemHighest + topItemsHighest + 20
                }px`;
              }
            }, 50);
          } else if (labelLocation == "bottom") {
            if (index % 2 === 0) {
              item.classList.remove("timeline__item--top");
              item.classList.add("timeline__item--bottom");
            } else {
              item.classList.remove("timeline__item--bottom");
              item.classList.add("timeline__item--top");
            }

            // Fix: Ensure rendering is complete before measuring heights
            setTimeout(() => {
              const topItems = el.querySelectorAll(".timeline__item--top");
              topItems.forEach((item) => {
                item.style.height = "fit-content";
              });
              const topItemsHighest = highestOf(topItems);
              topItems.forEach((item) => {
                item.style.height = `${topItemsHighest}px`;
              });

              if (timelineDivider) {
                timelineDivider.style.top = `${topItemsHighest}px`;
              }
              allTimelineNavButton.forEach((btn) => {
                btn.style.top = `${topItemsHighest}px`;
              });

              const bottomItems = el.querySelectorAll(".timeline__item--bottom");
              bottomItems.forEach((item) => {
                item.style.transform = `translateY(${topItemsHighest}px)`;
              });
              const bottomItemHighest = highestOf(bottomItems);

              if (itemsContainer) {
                itemsContainer.style.height = `${
                  bottomItemHighest + topItemsHighest
                }px`;
              }
            }, 50);
          }
        }
      }

      if (renderedMode === "vertical") {
        // On mobile every item is stacked against the left hand bar, so the
        // start / end preference does not apply.
        const verticalPosition = isMobile() ? "start" : position;

        if (verticalPosition == "start") {
          const rightItems = el.querySelectorAll(".timeline__item--right");

          rightItems.forEach((item) => {
            item.classList.remove("timeline__item--right");
            item.classList.add("timeline__item--left");
          });
        } else if (verticalPosition == "end") {
          const leftItems = el.querySelectorAll(".timeline__item--left");

          leftItems.forEach((item) => {
            item.classList.remove("timeline__item--left");
            item.classList.add("timeline__item--right");
          });
        }
      }
    });
  };

  const instances = [];

  $(".bp_titleline").each(function (_index, timeline_item) {
    const timelineData = $(timeline_item).data("timeline");
    timeline_item.removeAttribute("data-timeline");

    if (!timelineData) return;

    const {
      timeline_type,
      date_location,
      start_item,
      move_item,
      visible_items,
      vertica_trigger,
      rtl_mode,
      content_position = "",
    } = timelineData;

    const mode = timeline_type || "vertical";

    $(timeline_item).addClass(`content_${timeline_type}_${content_position}`);

    // One broken timeline must not stop the rest of the page from booting.
    try {
      $(timeline_item).timeline({
        mode: mode,
        horizontalStartPosition: toHorizontalPosition(date_location),
        forceVerticalMode: MOBILE_BREAKPOINT,
        verticalStartPosition: toVerticalPosition(date_location),
        verticalTrigger: `${toInt(vertica_trigger, 15)}%`,
        moveItems: toInt(move_item, 1),
        startIndex: toInt(start_item, 0),
        visibleItems: toInt(visible_items, 3),
        rtlMode: rtl_mode === "1",
      });

      maintainContentPosition(
        timeline_item,
        mode,
        content_position,
        toHorizontalPosition(date_location)
      );

      instances.push({
        el: timeline_item,
        mode: mode,
        position: content_position,
        labelLocation: toHorizontalPosition(date_location),
      });
    } catch (error) {
      console.error("Timeline: failed to initialise a timeline.", error);
    }
  });

  if (!instances.length) return;

  // The library reveals items with `.fadeIn` while they scroll into view, but it
  // only tests whether an item is *inside* the viewport. An item that was jumped
  // past (anchor link, fast scroll, a re-render after resize) never passes that
  // test and would stay at `opacity: 0` forever, so reveal it here instead.
  const revealItemsScrolledPast = () => {
    instances.forEach(({ el }) => {
      el.querySelectorAll(
        ".timeline__item.animated:not(.fadeIn)"
      ).forEach((item) => {
        const rect = item.getBoundingClientRect();
        if (rect.top + rect.height < 0) {
          item.classList.add("fadeIn");
        }
      });
    });
  };

  let revealScheduled = false;
  window.addEventListener("scroll", function () {
    if (revealScheduled) return;
    revealScheduled = true;
    window.requestAnimationFrame(function () {
      revealScheduled = false;
      revealItemsScrolledPast();
    });
  });

  // The library re-renders itself on resize (debounced by 250ms) and wipes the
  // classes and inline styles applied above, so re-apply them afterwards.
  let resizeTimer = null;
  let lastWidth = window.innerWidth;

  window.addEventListener("resize", function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      if (window.innerWidth === lastWidth) return;
      lastWidth = window.innerWidth;

      instances.forEach(({ el, mode, position, labelLocation }) => {
        try {
          maintainContentPosition(el, mode, position, labelLocation);
        } catch (error) {
          console.error("Timeline: failed to re-layout a timeline.", error);
        }
      });

      revealItemsScrolledPast();
    }, 400);
  });
});
