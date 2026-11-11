( function ( wp ) {
	const { registerBlockType, createBlock } = wp.blocks;
	const { useBlockProps, BlockControls } = wp.blockEditor;
	const {
		ComboboxControl,
		Dropdown,
		Placeholder,
		Spinner,
		ToolbarButton,
	} = wp.components;
	const { useSelect, useDispatch } = wp.data;
	const { createElement: el, Fragment } = wp.element;
	const { decodeEntities } = wp.htmlEntities;
	const { __ } = wp.i18n;

	/**
	 * Pattern title for combobox options.
	 *
	 * @param {Object} pattern wp_block entity record.
	 * @return {string} Plain-text title.
	 */
	function getPatternTitle( pattern ) {
		if ( pattern.title && pattern.title.raw ) {
			return pattern.title.raw;
		}
		if ( pattern.title && pattern.title.rendered ) {
			return decodeEntities(
				pattern.title.rendered.replace( /<[^>]+>/g, '' )
			);
		}
		return String( pattern.id );
	}

	/**
	 * Toolbar dropdown: searchable list of synced patterns (wp_block).
	 *
	 * @param {Object}   props          Component props.
	 * @param {Function} props.onSelect Called with the chosen pattern ID.
	 * @return {Object} Element.
	 */
	function PatternToolbarPicker( { onSelect } ) {
		const patterns = useSelect( function ( select ) {
			return select( 'core' ).getEntityRecords( 'postType', 'wp_block', {
				per_page: 100,
				status: 'publish',
				orderby: 'title',
				order: 'asc',
			} );
		}, [] );

		const options = ( patterns || [] ).map( function ( pattern ) {
			return {
				value: String( pattern.id ),
				label: getPatternTitle( pattern ),
			};
		} );

		return el( Dropdown, {
			popoverProps: { placement: 'bottom-start' },
			renderToggle: function ( { isOpen, onToggle } ) {
				return el( ToolbarButton, {
					icon: 'block-default',
					label: __( 'Select pattern', 'aqua-pattern-library' ),
					onClick: onToggle,
					'aria-expanded': isOpen,
					isPressed: isOpen,
				} );
			},
			renderContent: function () {
				if ( null === patterns ) {
					return el(
						'div',
						{ style: { padding: '8px 12px' } },
						el( Spinner, null )
					);
				}

				if ( ! options.length ) {
					return el(
						'p',
						{ style: { margin: 0, padding: '8px 12px' } },
						__( 'No patterns found.', 'aqua-pattern-library' )
					);
				}

				return el(
					'div',
					{
						style: {
							minWidth: '240px',
							padding: '8px 12px',
						},
					},
					el( ComboboxControl, {
						label: __( 'Pattern', 'aqua-pattern-library' ),
						value: null,
						options: options,
						onChange: function ( value ) {
							if ( value ) {
								onSelect( parseInt( value, 10 ) );
							}
						},
					} )
				);
			},
		} );
	}

	registerBlockType( 'all-the-things/pattern', {
		edit: function ( props ) {
			const { clientId } = props;
			const blockProps = useBlockProps();
			const { replaceBlocks } = useDispatch( 'core/block-editor' );

			function selectPattern( id ) {
				replaceBlocks(
					clientId,
					createBlock( 'core/block', { ref: id } )
				);
			}

			return el(
				Fragment,
				null,
				el(
					BlockControls,
					{ group: 'block' },
					el( PatternToolbarPicker, { onSelect: selectPattern } )
				),
				el(
					'div',
					blockProps,
					el( Placeholder, {
						icon: 'block-default',
						label: __( 'Pattern', 'aqua-pattern-library' ),
						instructions: __(
							'Select a pattern from the block toolbar.',
							'aqua-pattern-library'
						),
					} )
				)
			);
		},
		save: function () {
			return null;
		},
	} );
} )( window.wp );
