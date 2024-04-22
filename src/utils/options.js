import { __ } from '@wordpress/i18n';

import { verticalLineIcon, horizontalLineIcon } from './icons';

export const layouts = [
	{ label: __('Vertical', 'features-request'), value: 'vertical', icon: verticalLineIcon },
	{ label: __('Horizontal', 'features-request'), value: 'horizontal', icon: horizontalLineIcon }
];

export const generalStyleTabs = [
	{ name: 'general', title: __('General', 'features-request') },
	{ name: 'style', title: __('Style', 'features-request') }
];