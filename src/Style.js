import { getBackgroundCSS, getBorderCSS, getColorsCSS, getIconCSS, getSeparatorCSS, getMultiShadowCSS, getSpaceCSS, getTypoCSS } from '../../Components/utils/getCSS';

const Style = ({ attributes, clientId }) => {
	const { columnGap, rowGap, alignment, textAlign, width, background, typography, color, colors, icon, separator, padding, margin, border, shadow } = attributes;

	const mainSl = `#fereqFeaturesRequest-${clientId}`;
	const blockSl = `${mainSl} .fereqFeaturesRequest`;

	return <style dangerouslySetInnerHTML={{
		__html: `
		${getTypoCSS('', typography)?.googleFontLink}
		${getTypoCSS(`${blockSl} .content`, typography)?.styles}

		${mainSl}{
			text-align: ${alignment};
		}
		${blockSl}{
			grid-gap: ${rowGap} ${columnGap};
			text-align: ${textAlign};
			width: ${['0px', '0%', '0em'].includes(width) ? 'auto' : width};
			${getBackgroundCSS(background)}
			padding: ${getSpaceCSS(padding)};
			margin: ${getSpaceCSS(margin)};
			${getBorderCSS(border)}
			box-shadow: ${getMultiShadowCSS(shadow)};
		}
		${blockSl} .content{
			color: ${color};
			${getColorsCSS(colors)}
		}
		${blockSl} .icon{
			${getIconCSS(icon)}
		}
		${blockSl} .separator{
			${getSeparatorCSS(separator)}
		}
	`}} />;
}
export default Style;