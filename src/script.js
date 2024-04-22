import { render } from 'react-dom';

import './style.scss';
import Style from './Style';

// Block Name
document.addEventListener('DOMContentLoaded', () => {
	const blockEls = document.querySelectorAll('.wp-block-fereq-features-request');
	blockEls.forEach(blockEl => {
		const attributes = JSON.parse(blockEl.dataset.attributes);

		render(<>
			<Style attributes={attributes} clientId={attributes.cId} />

			<FeaturesRequest attributes={attributes} />
		</>, blockEl);

		blockEl?.removeAttribute('data-attributes');
	});
});

const FeaturesRequest = ({ attributes }) => {
	const { items, columns, layout, content, icon, img } = attributes;

	return <div className={`fereqFeaturesRequest columns-${columns.desktop} columns-tablet-${columns.tablet} columns-mobile-${columns.mobile} ${layout || 'vertical'}`}>
		{items?.map((item, index) => {
			const { number, text } = item;

			return <div key={index} id={`fereqFeaturesRequestItem-${index}`}>
				<div className='fereqFeaturesRequestItem'>
					<span className='number'>{number}</span>
					<span className='text' dangerouslySetInnerHTML={{ __html: text }} />
				</div>
			</div>;
		})}

		{content && <p className='content' dangerouslySetInnerHTML={{ __html: content }} />}

		{img?.url && <img src={img.url} alt={img?.alt} />}

		{icon?.class && <i className={`icon ${icon.class}`}></i>}

		<span className='separator'></span>
	</div>
}