(function() {
    const __ = wp.i18n.__;
    const createElement = window.wp.element.createElement;
    const { useBlockProps, BlockControls, InspectorControls } = window.wp.blockEditor
    const { PanelBody, SelectControl, TextControl } = window.wp.components
    const registerBlockType = window.wp.blocks.registerBlockType;

    registerBlockType( 'piotrpress/asset-block', {
        edit: function( { attributes, setAttributes } ) {
            let { type, handle } = attributes;

            if ( !type ) {
                type = 'script';
                setAttributes({ type: 'script' });
            }

            return createElement(
                'div',
                useBlockProps(),
                BlockControls,
                createElement(
                    InspectorControls,
                    {},
                    createElement(
                        PanelBody,
                        {
                            title: __('Settings', 'piotrpress-asset-block')
                        },
                        createElement(
                            SelectControl,
                            {
                                label: __('Type', 'piotrpress-asset-block'),
                                value: type,
                                options: [
                                    { label: __('script', 'piotrpress-asset-block'), value: 'script' },
                                    { label: __('style', 'piotrpress-asset-block'), value: 'style' }
                                ],
                                onChange: (type) => { setAttributes({type: type}); }
                            }
                        ),
                        createElement(
                            TextControl,
                            {
                                label: __('Handle', 'piotrpress-asset-block'),
                                value: handle,
                                onChange: (handle) => { setAttributes({handle: handle}); }
                            }
                        )
                    )
                ),
                createElement(
                    'div',
                    { className: 'components-placeholder' },
                    createElement(
                        'code',
                        {},
                        `wp_enqueue_${type}( '${handle}' )`
                    )
                )
            );
        }
    } );
})();