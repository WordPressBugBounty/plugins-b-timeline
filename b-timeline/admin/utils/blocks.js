// This plugin ships a shortcode-based timeline (no Gutenberg blocks of its own),
// so every card below except the first is a Pro upsell. Icons come from the
// local copy in `proBlockIcons.js` — nothing here registers a block.
import {
	timelineIcon,
	mediaStoryIcon,
	yearNavIcon,
	roadmapIcon,
	careerIcon,
	eventScheduleIcon,
	dynamicPostIcon,
	accordionIcon,
	companyHistoryIcon
} from './proBlockIcons';

const docsURL = 'https://bplugins.com/docs/b-timeline/';

// The `name` value must match how blocks are keyed in the disabled-blocks
// option (`bptl_disabled_blocks`): the shortcode timeline uses "b-timeline";
// each pro block uses its build/blocks folder name. The first card is marked
// `required` because the shortcode timeline is the plugin itself and cannot be
// switched off.
export default [
	{
		name: 'b-timeline-block',
		title: 'Timeline Block',
		icon: timelineIcon,
		demo: 'https://bblockswp.com/demo/timeline-block-all-demos/',
		docs: docsURL,
		required: true,
		status: 'published'
	},
	{
		name: 'media-story-timeline',
		title: 'Media Story Timeline',
		icon: mediaStoryIcon,
		isPremium: true,
		badge: 'New',
		demo: 'https://bblockswp.com/demo/timeline-block-media-story-timeline/',
		status: 'published'
	},
	{
		name: 'year-navigator',
		title: 'Year Navigator',
		icon: yearNavIcon,
		isPremium: true,
		badge: 'New',
		demo: 'https://bblockswp.com/demo/timeline-block-year-navigator/',
		status: 'published'
	},
	{
		name: 'roadmap-timeline',
		title: 'Product Roadmap',
		icon: roadmapIcon,
		isPremium: true,
		badge: 'New',
		demo: 'https://bblockswp.com/demo/timeline-block-product-roadmap/',
		status: 'published'
	},
	{
		name: 'career-timeline',
		title: 'Career Timeline',
		icon: careerIcon,
		isPremium: true,
		badge: 'New',
		demo: 'https://bblockswp.com/demo/timeline-block-career-timeline/',
		status: 'published'
	},
	{
		name: 'event-schedule',
		title: 'Event Schedule',
		icon: eventScheduleIcon,
		isPremium: true,
		badge: 'New',
		demo: 'https://bblockswp.com/demo/timeline-block-event-schedule/',
		status: 'published'
	},
	{
		name: 'dynamic-post-timeline',
		title: 'Dynamic Post Timeline',
		icon: dynamicPostIcon,
		isPremium: true,
		badge: 'New',
		demo: 'https://bblockswp.com/demo/timeline-block-dynamic-post-timeline/',
		status: 'published'
	},
	{
		name: 'accordion-timeline',
		title: 'Accordion Timeline',
		icon: accordionIcon,
		isPremium: true,
		badge: 'New',
		demo: 'https://bblockswp.com/demo/timeline-block-accordion-timeline/',
		status: 'published'
	},
	{
		name: 'company-history-timeline',
		title: 'Company History Timeline',
		icon: companyHistoryIcon,
		isPremium: true,
		badge: 'New',
		demo: 'https://bblockswp.com/demo/timeline-block-company-history-timeline/',
		status: 'published'
	}
];
