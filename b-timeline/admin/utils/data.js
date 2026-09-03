const slug = "b-timeline";
import { heroImage } from "./heroImage";

export const dashboardInfo = (info) => {
  const { version, isPremium, hasPro, licenseActiveNonce, deleteDataOnUninstall, uninstallNonce, adminUrl = '', nonce, action } = info;

  const proSuffix = isPremium ? ' Pro' : '';

  return {
    name: `Timeline${proSuffix}`,
    displayName: `Timeline${proSuffix} - Vertical and Horizontal Timeline Layouts`,
    description: "Timeline is a liteweight WordPress plugin that lets you create and display timeline in any Posts / Pages/ Widget .The plugin is very easy to use and anyone can use the plugin easily without any technical knowledge.",
    slug,
    version,
    isPremium,
    hasPro,
    deleteDataOnUninstall,
    uninstallNonce,
    adminUrl,
    nonce,
    action,
    displayOurPlugins: true,
    media: {
      logo: `https://ps.w.org/${slug}/assets/icon-128x128.png`,
      banner: `https://ps.w.org/${slug}/assets/banner-772x250.png`,
      thumbnail: heroImage,
      // proThumbnail: `https://bplugins.com/wp-content/themes/b-technologies/assets/images/products/${slug}-pro.png`,
      // video: 'https://www.youtube.com/watch?v=milYZrqLJsE',
      // isYoutube: true
    },
    pages: {
      org: `https://wordpress.org/plugins/${slug}/`,
      landing: `https://bplugins.com/products/${slug}/`,
      docs: `https://bplugins.com/docs/${slug}/`,
      pricing: `https://bplugins.com/products/${slug}/pricing`,
    },
    freemius: {
      product_id: '17342',
      plan_id: '28900',
      public_key: 'pk_624005a9d0c56ff46db6602f5f730',
    },
    licenseActiveNonce,
    startButton: {
      label: 'Start Now',
      url: `${adminUrl}post-new.php?post_type=btimeline`
    }
  }
}

const shortcodeTabIcon = (
  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M8 4H5v16h3M16 4h3v16h-3" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
  </svg>
);

const gutenbergTabIcon = (
  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M19.5 12c0-4.14-3.36-7.5-7.5-7.5S4.5 7.86 4.5 12s3.36 7.5 7.5 7.5 7.5-3.36 7.5-7.5Z" stroke="currentColor" strokeWidth="1.5" />
    <path d="M12 8v8M8 12h8" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
  </svg>
);

const elementorTabIcon = (
  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M3 5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5Z" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
    <path d="M7 7h10M7 12h10M7 17h10M7 7v10" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
  </svg>
);

export const welcomeInfo = (adminUrl = '/wp-admin/') => ({
  keywords: ['Horizontal', 'Vertical', 'Milestones', 'Roadmap', 'History'],
  keywordsLabel: 'Layouts',

  gettingStarted: {
    tabs: [
      {
        key: 'shortcode',
        label: 'Shortcode',
        icon: shortcodeTabIcon,
        steps: [
          {
            num: 1,
            title: 'Create a Timeline',
            body: 'Go to <strong>Timeline</strong> &rsaquo; <strong>Add New</strong> and give your timeline a title.',
            link: { url: `${adminUrl}post-new.php?post_type=btimeline`, label: 'Create Timeline' }
          },
          {
            num: 2,
            title: 'Configure & Style',
            body: 'Use the <strong>Timeline Configuration</strong> panel to pick <strong>Vertical</strong> or <strong>Horizontal</strong> layout, then style the bar, dots, and items.'
          },
          {
            num: 3,
            title: 'Copy the Shortcode',
            body: 'Save the timeline and copy the shortcode shown above the editor (e.g. <code>[btimeline id="123"]</code>).',
            link: { url: `${adminUrl}edit.php?post_type=btimeline`, label: 'View All Timelines' }
          },
          {
            num: 4,
            title: 'Paste Anywhere',
            body: 'Paste the shortcode into any post, page, or text widget and hit <strong>Publish</strong> to see it live.'
          }
        ]
      },
      {
        key: 'gutenberg',
        label: 'Gutenberg',
        icon: gutenbergTabIcon,
        steps: [
          {
            num: 1,
            title: 'Create a Timeline',
            body: 'Go to <strong>Timeline</strong> &rsaquo; <strong>Add New</strong>, build your timeline items, and save.',
            link: { url: `${adminUrl}post-new.php?post_type=btimeline`, label: 'Create Timeline' }
          },
          {
            num: 2,
            title: 'Open the Block Editor',
            body: 'Edit the post or page where the timeline should appear.'
          },
          {
            num: 3,
            title: 'Add a Shortcode Block',
            body: 'Click <strong>+</strong>, search for <strong>Shortcode</strong>, and insert the block.'
          },
          {
            num: 4,
            title: 'Paste & Publish',
            body: 'Paste <code>[btimeline id="123"]</code> into the block and click <strong>Publish/Update</strong>.'
          }
        ]
      },
      {
        key: 'elementor',
        label: 'Elementor',
        icon: elementorTabIcon,
        steps: [
          {
            num: 1,
            title: 'Create a Timeline',
            body: 'Go to <strong>Timeline</strong> &rsaquo; <strong>Add New</strong> to build and style your timeline.',
            link: { url: `${adminUrl}post-new.php?post_type=btimeline`, label: 'Create Timeline' }
          },
          {
            num: 2,
            title: 'Copy the Shortcode',
            body: 'From the <strong>Timeline</strong> list, find your timeline and copy its shortcode (e.g. <code>[btimeline id="123"]</code>).',
            link: { url: `${adminUrl}edit.php?post_type=btimeline`, label: 'View All Timelines' }
          },
          {
            num: 3,
            title: 'Add to Page',
            body: 'Open any page/post in Elementor. Drag and drop the <strong>Shortcode</strong> or <strong>Text Editor</strong> widget into your canvas.'
          },
          {
            num: 4,
            title: 'Paste & Publish',
            body: 'Paste the copied shortcode into the widget settings and click <strong>Publish/Update</strong> to save.'
          }
        ]
      }
    ]
  },

  changelogs: [
    {
      version: "2.0.3 - 31 August 2026",
      type: "update",
      list: [
        "<strong>New:</strong> Added Dynamic Post Timeline block(Pro) — create timelines dynamically from any custom post type, filtered by taxonomy, terms, and author(Pro).",
        "<strong>New:</strong> Added Accordion Timeline block(Pro) — collapsible groups of steps with custom status markers and interactive toggle(Pro).",
        "<strong>New:</strong> Added Company History Timeline block(Pro) — interactive year card with clickable year rail and auto- slide navigation(Pro).",
        "<strong>New:</strong> Added new feature blocks including Career Timeline(Pro), Media Story Timeline(Pro), Event Schedule(Pro), Roadmap Timeline(Pro), and Year Navigator(Pro).",
        "<strong>Improvement:</strong> Improved editor preview for Horizontal and Vertical layouts with real - time live preview synchronization.",
        "<strong>Improvement:</strong> Improved Accordion Timeline expand/ collapse functionality in both editor and frontend.",
        "<strong>Update:</strong> Updated settings UI labels for Dot controls and styling options."
      ]
    },
    {
      version: "2.0.2 - 11 April 2026",
      type: "fix",
      list: [
        "<strong>Fix:</strong> Fixed Issues.",
        "<strong>Update:</strong> Updated Pro Version - Add New Theme & Animation Features."
      ],
    },
    {
      version: "2.0.1 - 24 February 2026",
      type: "update",
      list: [
        "<strong>Improvement:</strong> Redesigned the full settings layout and improved the admin dashboard interface.",
        "<strong>Improvement:</strong> Optimized files and enhanced overall code readability for better maintainability.",
        "<strong>Improvement:</strong> Optimized plugin files."
      ],
    },
    {
      version: "2.0.0 - 25 January 2026",
      type: "fix",
      list: [
        "<strong>Fix:</strong> Fixed horizontal timeline issue.",
        "<strong>Improvement:</strong> Optimized plugin files."
      ],
    },
    {
      version: "1.1.9 - 15 November 2025",
      type: "fix",
      list: ["<strong>Fix:</strong> Fixed Issues."],
    },
    {
      version: "1.1.8 - 5 November 2025",
      type: "update",
      list: ["<strong>Update:</strong> Updated dashboard."],
    },
    {
      version: "1.1.7 - 21 October 2025",
      type: "fix",
      list: ["<strong>Fix:</strong> Fixed conflict issues and updated demos."],
    },
    {
      version: "1.1.6 - 16 September 2025",
      type: "new",
      list: ["<strong>New:</strong> Add Modern Dashboard."],
    },
    {
      version: "1.1.5 - 19 May 2025",
      type: "fix",
      list: ["<strong>Fix:</strong> Fixed Mobile view issue."],
    },
    {
      version: "1.1.4 - 24 April 2025",
      type: "fix",
      list: ["<strong>Fix:</strong> Fixed textdomain issues and seo issue."],
    },
    {
      version: "1.1.3 - 24 April 2025",
      type: "fix",
      list: ["<strong>Fix:</strong> Fixed textdomain issues."],
    },
    {
      version: "1.1.2 - 20 March 2025",
      type: "fix",
      list: ["<strong>Fix:</strong> Fixed Issues."],
    },
    {
      version: "1.1.1 - 11 March 2025",
      type: "fix",
      list: ["<strong>Fix:</strong> Fixed Issues."],
    },
  ],
  changelogsLimit: 5,
  changelogsReadMoreLabel: 'View More Changelogs',

  proFeatures: [
      "ShortCode to use Timeline Block anywhere.",
      "Eleven extra professional theme designs.",
      "Classic Editor for advanced formatting.",
      "Customizable and styled timeline icons.",
      "Advanced tools for ultimate design control.",
      "Animation effects for timeline items.",
      "Access to AI Timeline Content Generator.",
      "Media Story Timeline block with image, video & lightbox.",
      "Year Navigator block for company history pages.",
      "Product Roadmap block with statuses, progress & filters.",
      "Career Timeline block for resume & experience pages.",
      "Event Schedule block with horizontal time slots."
    ]
})

export const demoInfo = {
  allInOneLabel: 'See All Demos',
  allInOneLink: "https://bblockswp.com/demo/timeline-block-all-demos/",
  demos: [
    {
      icon: "",
      title: "Default Timeline",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline/",
    },
    {
      icon: "",
      title: "Default Customized Timeline",
      type: "iframe",
      url: "https://bblockswp.com/demo/customize-timeline-default-theme/",
    },
    {
      icon: "",
      title: "Template 1(Accordion Timeline)",
      type: "iframe",
      url: "https://bblockswp.com/demo/accordion-timeline-with-classic-editor-pro/",
    },
    {
      icon: "",
      title: "Template 2(Vertical & Horizontal Options)",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-with-icon-and-date-pro/",
    },
    {
      icon: "",
      title: "Template 3",
      type: "iframe",
      url: "https://bblockswp.com/demo/theme-3-pro/",
    },
    {
      icon: "",
      title: "Template 4",
      type: "iframe",
      url: "https://bblockswp.com/demo/theme-4-pro/",
    },
    {
      icon: "",
      title: "Template 5",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-block-theme-5-pro/",
    },
    {
      icon: "",
      title: "Template 6",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-block-theme-6-pro/",
    },
    {
      icon: "",
      title: "Template 7",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-block-theme-7-pro/",
    },
    {
      icon: "",
      title: "Template 8",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-block-theme-8-pro/",
    },
    {
      icon: "",
      title: "Template 9",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-block-theme-9-pro/"
    },
    {
      icon: "",
      title: "Sticky Scroll Story",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-block-sticky-scroll-story/"
    },
    {
      icon: "",
      title: "Rotary Wheel",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-block-rotary-wheel/"
    },
    {
      icon: "",
      title: "Media Story Timeline Block",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-block-media-story-timeline/"
    },
    {
      icon: "",
      title: "Accordion Timeline Block",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-block-accordion-timeline/"
    },
    {
      icon: "",
      title: "Year Navigator Block",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-block-year-navigator/"
    },
    {
      icon: "",
      title: "Product Roadmap Block",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-block-product-roadmap/"
    },
    {
      icon: "",
      title: "Career Timeline Block",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-block-career-timeline/"
    },
    {
      icon: "",
      title: "Event Schedule Block",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-block-event-schedule/"
    },
    {
      icon: "",
      title: "Dynamic Post Timeline Block",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-block-dynamic-post-timeline/"
    },
    {
      icon: "",
      title: "Company History Timeline Block",
      type: "iframe",
      url: "https://bblockswp.com/demo/timeline-block-company-history-timeline/"
    } 
  ],
}

export const pricingInfo = {
  logo: `https://ps.w.org/${slug}/assets/icon-128x128.png`, // Optional
  pluginId: 17342,
  planId: 28900,
  licenses: [
    1,
    3,
    null
  ],
  button: {
    label: 'Buy Now ➜'
  },
  featured: {
    selected: 3, // choose from licenses item
  }
}
