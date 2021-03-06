<?php

public function add_demo_group_controls()
{
	return array(
		array(
			'id'           => 'demo-group',
			'label'        => __('Test Control Group', 'lwwb'),
			'type'         => Control::GROUP,
			'dependencies' => array(
				array(
					'control'  => 'lwwb_tab_control',
					'operator' => '===',
					'value'    => 'content',
				),
			),
			'fields'       => array(
				array(
					'id'          => 'demo-text',
					'keywords'    => 'text',
					'label'       => __('Text control', 'lwwb'),
					'description' => __('Text control description', 'lwwb'),
					'default'     => __('default text', 'lwwb'),
					'input_type'  => 'text', //number,
					'type'        => Control::TEXT,

				),
				array(
					'id'       => 'demo-divider',
					'keywords' => 'divider',
					// 'label'       => __('Divider control', 'lwwb'),
					// 'description' => __('Divider control description', 'lwwb'),
					'default'  => __('default divider', 'lwwb'),
					'type'     => Control::DIVIDER,

				),
				array(
					'id'       => 'demo-heading',
					'keywords' => 'heading',
					'label'    => __('Header control', 'lwwb'),
					// 'description' => __('Header control description', 'lwwb'),
					'default'  => __('default heading', 'lwwb'),
					'type'     => Control::HEADING,

				),
				array(
					'id'       => 'demo-radio',
					'keywords' => 'radio',
					'label'    => __('Radio control', 'lwwb'),
					// 'description' => __('Radio control description', 'lwwb'),
					'default'  => 'choice2',
					'type'     => Control::RADIO,
					'choices'  => array(
						'choice1' => __('Choice 1', 'lwwb'),
						'choice2' => __('Choice 2', 'lwwb'),
						'choice3' => __('Choice 3', 'lwwb'),
					),

				),
				array(
					'id'       => 'demo-checkbox',
					'keywords' => 'checkbox',
					'label'    => __('Checkbox control', 'lwwb'),
					// 'description' => __('Checkbox control description', 'lwwb'),
					'default'  => array('choice2', 'choice3'),
					'type'     => Control::CHECKBOX,
					'choices'  => array(
						'choice1' => __('Choice 1', 'lwwb'),
						'choice2' => __('Choice 2', 'lwwb'),
						'choice3' => __('Choice 3', 'lwwb'),
					),

				),
				array(
					'id'       => 'demo-select',
					'keywords' => 'select',
					'label'    => __('Select control', 'lwwb'),
					// 'description' => __('Select control description', 'lwwb'),
					'default'  => 'choice2',
					'type'     => Control::SELECT,
					'choices'  => array(
						'choice1' => __('Choice 1', 'lwwb'),
						'choice2' => __('Choice 2', 'lwwb'),
						'choice3' => __('Choice 3', 'lwwb'),
					),

				),
				array(
					'id'       => 'demo-select2',
					'keywords' => 'select2',
					'label'    => __('Select2 control', 'lwwb'),
					// 'description' => __('Select2 control description', 'lwwb'),
					'default'  => 'choice2',
					'type'     => Control::SELECT2,
					'choices'  => array(
						'choice1' => __('Choice 1', 'lwwb'),
						'choice2' => __('Choice 2', 'lwwb'),
						'choice3' => __('Choice 3', 'lwwb'),
					),

				),
				array(
					'id'       => 'demo-textarea',
					'keywords' => 'textarea',
					'label'    => __('Textarea control', 'lwwb'),
					// 'description' => __('Textarea control description', 'lwwb'),
					'default'  => __('Textarea default content', 'lwwb'),
					'type'     => Control::TEXTAREA,

				),
				array(
					'id'       => 'demo-image',
					'keywords' => 'image, media',
					'label'    => __('Image', 'lwwb'),
					'type'     => Control::MEDIA_UPLOAD,
					'default'  => array(
						'url' => '',
						'id'  => '',
					),
				),

				array(
					'id'       => 'demo-radio-image',
					'keywords' => 'radio image',
					'label'    => __('Radio image control', 'lwwb'),
					// 'description' => __('Radio image control description', 'lwwb'),
					'default'  => 'choice2',
					'type'     => Control::RADIO_IMAGE,
					'choices'  => array(
						'choice1' => 'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png',
						'choice2' => 'https://www.itsnicethat.com/system/files/082017/59a68a947fa44c9e4d005b7a/images_slice_large/youtube_logo_redesign_graphic_design_digital_itsnicethat2.png',
						'choice3' => 'https://as-images.apple.com/is/image/AppleInc/aos/published/images/o/g/og/default/og-default?wid=1200&hei=630&fmt=jpeg&qlt=95&op_usm=0.5,0.5&.v=1525370171638',
					),

				),

				array(
					'id'       => 'demo-button-set',
					'keywords' => 'button set',
					'label'    => __('Button set control', 'lwwb'),
					// 'description' => __('Button set control description', 'lwwb'),
					'default'  => 'center',
					'type'     => Control::BUTTON_SET,
					'choices'  => array(
						'left'   => __('Left', 'lwwb'),
						'center' => __('Center', 'lwwb'),
						'right'  => __('Right', 'lwwb'),
					),

				),
				array(
					'id'           => 'demo-button-set-icon',
					'keywords'     => 'button set',
					'label'        => __('Button set control display icon', 'lwwb'),
					// 'description' => __('Button set control description', 'lwwb'),
					'default'      => 'left',
					'type'         => Control::BUTTON_SET,
					'display_type' => 'icon',
					'choices'      => array(
						'left'   => 'fa fa-align-left',
						'center' => 'fa fa-align-center',
						'right'  => 'fa fa-align-right',
					),

				),
				array(
					'id'            => 'border-width',
					'keywords'      => 'padding dimension',
					'label'         => __('Dimension control', 'lwwb'),
					// 'description' => __('Dimension control description', 'lwwb'),
					'type'          => Control::DIMENSIONS,
					'default'       => array(
						'desktop-top'    => '2',
						'desktop-right'  => '3',
						'desktop-bottom' => '4',
						'desktop-left'   => '5',
						// 'tablet-top'     => '',
						// 'tablet-right'   => 'auto',
						// 'tablet-bottom'  => '',
						// 'tablet-left'    => 'auto',
						'mobile-top'     => '',
						'mobile-right'   => '',
						'mobile-bottom'  => '',
						'mobile-left'    => '',
						'unit'           => 'px',

					),
					'device_config' => array(
						'desktop' => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						// 'tablet'  => array(
						//     'top'    => esc_html__('Top', 'lwwb'),
						//     'right'  => esc_html__('Right', 'lwwb'),
						//     'bottom' => esc_html__('Bottom', 'lwwb'),
						//     'left'   => esc_html__('Left', 'lwwb'),
						// ),
						'mobile'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
					),
					'input_attrs'   => array(
						'min'  => '0',
						'max'  => '100',
						'step' => '1',
					),

					'css_format'    => "ELMN_WRAPPER > .lwwb-elmn-content{border-width: {{ data['desktop-top'] }}{{ data.unit }} {{ data['desktop-right'] }}{{ data.unit }} {{ data['desktop-bottom'] }}{{ data.unit }} {{ data['desktop-left'] }}{{ data.unit }} ;}",
				),
				array(
					'id'         => 'border-style',
					'keywords'   => 'select2',
					'label'      => __('Border style control', 'lwwb'),
					// 'description' => __('Select2 control description', 'lwwb'),
					'default'    => 'solid',
					'type'       => Control::SELECT2,
					'choices'    => array(
						'none'   => __('None', 'lwwb'),
						'solid'  => __('Solid', 'lwwb'),
						'dashed' => __('Dashed', 'lwwb'),
					),
					'css_format' => 'ELMN_WRAPPER > .lwwb-elmn-content{border-style:{{ VALUE }};}',

				),
				array(
					'id'          => 'border-color',
					'keywords'    => 'color picker',
					'default'     => '#dd3333',
					'label'       => __('Color picker control', 'lwwb'),
					'description' => __('Color picker control description', 'lwwb'),
					'type'        => Control::COLOR_PICKER,
					'css_format'  => 'ELMN_WRAPPER > .lwwb-elmn-content{border-color:{{ VALUE }};}',
				),
				array(
					'id'      => 'demo-tab',
					'label'   => '',
					'default' => 'content',
					'type'    => Control::TAB,
					'choices' => array(
						'content'  => __('Content', 'lwwb'),
						'style'    => __('Style', 'lwwb'),
						'advanced' => __('Advanced', 'lwwb'),
					),

				),
				array(
					'id'       => 'demo-switcher',
					'keywords' => 'switcher',
					// 'label'        => __('Switcher control', 'lwwb'),
					// 'description' => __('Switcher control description', 'lwwb'),
					'default'  => '',
					'type'     => Control::SWITCHER,
				),
				array(
					'id'          => 'demo-slider',
					'keywords'    => 'slider',
					'label'       => __('Slider control', 'lwwb'),
					'description' => __('Slider control description', 'lwwb'),
					'default'     => '10',
					'type'        => Control::SLIDER,
					'input_attrs' => array(
						'min'  => '1',
						'max'  => '100',
						'step' => '1',
					),
				),
				array(
					'id'            => 'demo-slider-responsive',
					'keywords'      => 'slider',
					'label'         => __('Slider control responsive', 'lwwb'),
					'description'   => __('Slider control responsive description', 'lwwb'),
					'default'       => array(
						'desktop' => '10',
						'tablet'  => '12',
						'mobile'  => '14',
					),
					'type'          => Control::SLIDER,
					'input_attrs'   => array(
						'min'  => '1',
						'max'  => '100',
						'step' => '1',
					),
					'device_config' => array(
						'desktop' => 'desktop',
						'tablet'  => 'tablet',
						'mobile'  => 'mobile',
					),
				),
				array(
					'id'          => 'demo-heading-unit',
					'keywords'    => 'heading unit',
					'label'       => __('Unit control', 'lwwb'),
					'description' => __('Unit control description', 'lwwb'),
					'type'        => Control::HEADING,

				),
				array(
					'id'       => 'demo-unit',
					'keywords' => 'unit',
					// 'label'        => __('Unit control', 'lwwb'),
					// 'description' => __('Unit control description', 'lwwb'),
					'default'  => '',
					'type'     => Control::UNIT,
					'choices'  => array(
						'%'   => '%',
						'px'  => 'px',
						'rem' => 'rem',
					),
				),
				array(
					'id'          => 'demo-color-picker',
					'keywords'    => 'color picker',
					'default'     => '#dd3333',
					'label'       => __('Color picker control', 'lwwb'),
					'description' => __('Color picker control description', 'lwwb'),
					'type'        => Control::COLOR_PICKER,
				),
				array(
					'id'          => 'demo-date-picker',
					'keywords'    => 'date picker',
					'default'     => '2019-01-05',
					'label'       => __('Date picker control', 'lwwb'),
					'description' => __('Date picker control description', 'lwwb'),
					'type'        => Control::DATE_PICKER,
				),
				array(
					'id'          => 'demo-icon-picker',
					'keywords'    => 'icon picker',
					'default'     => 'fa fa-youtube',
					'label'       => __('Icon picker control', 'lwwb'),
					'description' => __('Icon picker control description', 'lwwb'),
					'type'        => Control::ICON_PICKER,
				),
				array(
					'id'          => 'demo-repeater-unit',
					'keywords'    => 'repeater unit',
					'label'       => __('Repeater control', 'lwwb'),
					'description' => __('Repeater control description', 'lwwb'),
					'type'        => Control::REPEATER,
					'default'     => array(
						array(
							'demo-repeat-text'              => '',
							'demo-repeat-divider'           => '',
							'demo-repeat-heading'           => '',
							'demo-repeat-radio'             => '',
							'demo-repeat-checkbox'          => '',
							'demo-repeat-select'            => '',
							'demo-repeat-select2'           => '',
							'demo-repeat-textarea'          => '',
							'demo-repeat-image'             => array(
								'url' => '',
								'id'  => '',
							),
							'demo-repeat-radio-image'       => '',
							'demo-repeat-button-set'        => '',
							'demo-repeat-button-set-icon'   => '',
							'demo-repeat-dimension'         => '',
							'demo-repeat-tab'               => '',
							'demo-repeat-switcher'          => '',
							'demo-repeat-slider'            => '',
							'demo-repeat-slider-responsive' => '',
							'demo-repeat-heading-unit'      => '',
							'demo-repeat-unit'              => '',
							'demo-repeat-color-picker'      => '',
							'demo-repeat-date-picker'       => '',
							'demo-repeat-icon-picker'       => '',
						),
					),
					'fields'      => array(
						array(
							'id'          => 'demo-repeat-text',
							'keywords'    => 'text',
							'label'       => __('Text control', 'lwwb'),
							'description' => __('Text control description', 'lwwb'),
							'default'     => __('default text', 'lwwb'),
							'input_type'  => 'text', //number,
							'type'        => Control::TEXT,

						),
						array(
							'id'       => 'demo-repeat-divider',
							'keywords' => 'divider',
							// 'label'       => __('Divider control', 'lwwb'),
							// 'description' => __('Divider control description', 'lwwb'),
							'default'  => __('default divider', 'lwwb'),
							'type'     => Control::DIVIDER,

						),
						array(
							'id'       => 'demo-repeat-heading',
							'keywords' => 'heading',
							'label'    => __('Header control', 'lwwb'),
							// 'description' => __('Header control description', 'lwwb'),
							'default'  => __('default heading', 'lwwb'),
							'type'     => Control::HEADING,

						),
						array(
							'id'       => 'demo-repeat-radio',
							'keywords' => 'radio',
							'label'    => __('Radio control', 'lwwb'),
							// 'description' => __('Radio control description', 'lwwb'),
							'default'  => 'choice2',
							'type'     => Control::RADIO,
							'choices'  => array(
								'choice1' => __('Choice 1', 'lwwb'),
								'choice2' => __('Choice 2', 'lwwb'),
								'choice3' => __('Choice 3', 'lwwb'),
							),

						),
						array(
							'id'       => 'demo-repeat-checkbox',
							'keywords' => 'checkbox',
							'label'    => __('Checkbox control', 'lwwb'),
							// 'description' => __('Checkbox control description', 'lwwb'),
							'default'  => array('choice2', 'choice3'),
							'type'     => Control::CHECKBOX,
							'choices'  => array(
								'choice1' => __('Choice 1', 'lwwb'),
								'choice2' => __('Choice 2', 'lwwb'),
								'choice3' => __('Choice 3', 'lwwb'),
							),

						),
						array(
							'id'       => 'demo-repeat-select',
							'keywords' => 'select',
							'label'    => __('Select control', 'lwwb'),
							// 'description' => __('Select control description', 'lwwb'),
							'default'  => 'choice2',
							'type'     => Control::SELECT,
							'choices'  => array(
								'choice1' => __('Choice 1', 'lwwb'),
								'choice2' => __('Choice 2', 'lwwb'),
								'choice3' => __('Choice 3', 'lwwb'),
							),

						),
						array(
							'id'       => 'demo-repeat-select2',
							'keywords' => 'select2',
							'label'    => __('Select2 control', 'lwwb'),
							// 'description' => __('Select2 control description', 'lwwb'),
							'default'  => 'choice2',
							'type'     => Control::SELECT2,
							'choices'  => array(
								'choice1' => __('Choice 1', 'lwwb'),
								'choice2' => __('Choice 2', 'lwwb'),
								'choice3' => __('Choice 3', 'lwwb'),
							),

						),
						array(
							'id'       => 'demo-repeat-textarea',
							'keywords' => 'textarea',
							'label'    => __('Textarea control', 'lwwb'),
							// 'description' => __('Textarea control description', 'lwwb'),
							'default'  => __('Textarea default content', 'lwwb'),
							'type'     => Control::TEXTAREA,

						),
						array(
							'id'       => 'demo-repeat-image',
							'keywords' => 'image, media',
							'label'    => __('Image', 'lwwb'),
							'type'     => Control::MEDIA_UPLOAD,
							'default'  => array(
								'url' => '',
								'id'  => '',
							),
						),

						array(
							'id'       => 'demo-repeat-radio-image',
							'keywords' => 'radio image',
							'label'    => __('Radio image control', 'lwwb'),
							// 'description' => __('Radio image control description', 'lwwb'),
							'default'  => 'choice2',
							'type'     => Control::RADIO_IMAGE,
							'choices'  => array(
								'choice1' => 'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png',
								'choice2' => 'https://www.itsnicethat.com/system/files/082017/59a68a947fa44c9e4d005b7a/images_slice_large/youtube_logo_redesign_graphic_design_digital_itsnicethat2.png',
								'choice3' => 'https://as-images.apple.com/is/image/AppleInc/aos/published/images/o/g/og/default/og-default?wid=1200&hei=630&fmt=jpeg&qlt=95&op_usm=0.5,0.5&.v=1525370171638',
							),

						),

						array(
							'id'       => 'demo-repeat-button-set',
							'keywords' => 'button set',
							'label'    => __('Button set control', 'lwwb'),
							// 'description' => __('Button set control description', 'lwwb'),
							'default'  => 'center',
							'type'     => Control::BUTTON_SET,
							'choices'  => array(
								'left'   => __('Left', 'lwwb'),
								'center' => __('Center', 'lwwb'),
								'right'  => __('Right', 'lwwb'),
							),

						),
						array(
							'id'           => 'demo-repeat-button-set-icon',
							'keywords'     => 'button set',
							'label'        => __('Button set control display icon', 'lwwb'),
							// 'description' => __('Button set control description', 'lwwb'),
							'default'      => 'left',
							'type'         => Control::BUTTON_SET,
							'display_type' => 'icon',
							'choices'      => array(
								'left'   => 'fa fa-align-left',
								'center' => 'fa fa-align-center',
								'right'  => 'fa fa-align-right',
							),

						),
						array(
							'id'            => 'demo-repeat-dimension',
							'keywords'      => 'padding dimension',
							'label'         => __('Dimension control', 'lwwb'),
							// 'description' => __('Dimension control description', 'lwwb'),
							'type'          => Control::DIMENSIONS,
							'default'       => array(
								'desktop-top'    => '2',
								'desktop-right'  => '3',
								'desktop-bottom' => '4',
								'desktop-left'   => '5',
								// 'tablet-top'     => '',
								// 'tablet-right'   => 'auto',
								// 'tablet-bottom'  => '',
								// 'tablet-left'    => 'auto',
								'mobile-top'     => '',
								'mobile-right'   => '',
								'mobile-bottom'  => '',
								'mobile-left'    => '',

							),
							'device_config' => array(
								'desktop' => array(
									'top'    => esc_html__('Top', 'lwwb'),
									'right'  => esc_html__('Right', 'lwwb'),
									'bottom' => esc_html__('Bottom', 'lwwb'),
									'left'   => esc_html__('Left', 'lwwb'),
								),
								// 'tablet'  => array(
								//     'top'    => esc_html__('Top', 'lwwb'),
								//     'right'  => esc_html__('Right', 'lwwb'),
								//     'bottom' => esc_html__('Bottom', 'lwwb'),
								//     'left'   => esc_html__('Left', 'lwwb'),
								// ),
								'mobile'  => array(
									'top'    => esc_html__('Top', 'lwwb'),
									'right'  => esc_html__('Right', 'lwwb'),
									'bottom' => esc_html__('Bottom', 'lwwb'),
									'left'   => esc_html__('Left', 'lwwb'),
								),
							),
							'input_attrs'   => array(
								'min'  => '',
								'max'  => '',
								'step' => '',
							),
						),
						array(
							'id'      => 'demo-repeat-tab',
							'label'   => '',
							'default' => 'content',
							'type'    => Control::TAB,
							'choices' => array(
								'content'  => __('Content', 'lwwb'),
								'style'    => __('Style', 'lwwb'),
								'advanced' => __('Advanced', 'lwwb'),
							),

						),
						array(
							'id'       => 'demo-repeat-switcher',
							'keywords' => 'switcher',
							// 'label'        => __('Switcher control', 'lwwb'),
							// 'description' => __('Switcher control description', 'lwwb'),
							'default'  => '',
							'type'     => Control::SWITCHER,
						),
						array(
							'id'          => 'demo-repeat-slider',
							'keywords'    => 'slider',
							'label'       => __('Slider control', 'lwwb'),
							'description' => __('Slider control description', 'lwwb'),
							'default'     => '10',
							'type'        => Control::SLIDER,
							'input_attrs' => array(
								'min'  => '1',
								'max'  => '100',
								'step' => '1',
							),
						),
						array(
							'id'            => 'demo-repeat-slider-responsive',
							'keywords'      => 'slider',
							'label'         => __('Slider control responsive', 'lwwb'),
							'description'   => __('Slider control responsive description', 'lwwb'),
							'default'       => array(
								'desktop' => '10',
								'tablet'  => '12',
								'mobile'  => '14',
							),
							'type'          => Control::SLIDER,
							'input_attrs'   => array(
								'min'  => '1',
								'max'  => '100',
								'step' => '1',
							),
							'device_config' => array(
								'desktop' => 'desktop',
								'tablet'  => 'tablet',
								'mobile'  => 'mobile',
							),
						),
						array(
							'id'          => 'demo-repeat-heading-unit',
							'keywords'    => 'heading unit',
							'label'       => __('Unit control', 'lwwb'),
							'description' => __('Unit control description', 'lwwb'),
							'type'        => Control::HEADING,

						),
						array(
							'id'       => 'demo-repeat-unit',
							'keywords' => 'unit',
							// 'label'        => __('Unit control', 'lwwb'),
							// 'description' => __('Unit control description', 'lwwb'),
							'default'  => '',
							'type'     => Control::UNIT,
							'choices'  => array(
								'%'   => '%',
								'px'  => 'px',
								'rem' => 'rem',
							),
						),
						array(
							'id'          => 'demo-repeat-color-picker',
							'keywords'    => 'color picker',
							'default'     => '#dd3333',
							'label'       => __('Color picker control', 'lwwb'),
							'description' => __('Color picker control description', 'lwwb'),
							'type'        => Control::COLOR_PICKER,
						),
						array(
							'id'          => 'demo-repeat-date-picker',
							'keywords'    => 'date picker',
							'default'     => '2019-01-05',
							'label'       => __('Date picker control', 'lwwb'),
							'description' => __('Date picker control description', 'lwwb'),
							'type'        => Control::DATE_PICKER,
						),
						array(
							'id'          => 'demo-repeat-icon-picker',
							'keywords'    => 'icon picker',
							'default'     => 'fa fa-youtube',
							'label'       => __('Icon picker control', 'lwwb'),
							'description' => __('Icon picker control description', 'lwwb'),
							'type'        => Control::ICON_PICKER,
						),
					),
				),
			),
		),
	);
}

public function add_tab_control()
{
	return array(
		array(
			'id'      => 'lwwb_tab_control',
			'label'   => '',
			'default' => 'content',
			'type'    => Control::TAB,
			'choices' => array(
				'content'  => __('Content', 'lwwb'),
				'style'    => __('Style', 'lwwb'),
				'advanced' => __('Advanced', 'lwwb'),
			),

		),
	);
}

public function add_search_control()
{
	return array(
		array(
			'id'          => 'lwwb_search_control',
			'label'       => '',
			'type'        => Control::TEXT,
			'input_type'  => 'search',
			'placeholder' => __('Control filter ..', 'lwwb'),

		),
	);
}

// add content controls
public function add_content_group_controls()
{
	return array(
		array(
			'id'           => 'content',
			'label'        => __('Content', 'lwwb'),
			'type'         => Control::GROUP,
			'dependencies' => array(
				array(
					'control'  => 'lwwb_tab_control',
					'operator' => '===',
					'value'    => 'content',
				),
			),
			'fields'       => array(
				array(
					'id'            => 'margin',
					'keywords'      => 'margin, dimension, ',
					'label'         => __('Margin', 'lwwb'),
					'type'          => Control::DIMENSIONS,
					'default'       => array(
						'desktop-top'    => '2',
						'desktop-right'  => '3',
						'desktop-bottom' => '4',
						'desktop-left'   => '5',
						'tablet-top'     => '',
						'tablet-right'   => 'auto',
						'tablet-bottom'  => '',
						'tablet-left'    => 'auto',
						'mobile-top'     => '',
						'mobile-right'   => '',
						'mobile-bottom'  => '',
						'mobile-left'    => '',

					),
					'device_config' => array(
						'desktop' => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'tablet'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'mobile'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
					),
					'input_attrs'   => array(
						'min'  => '',
						'max'  => '',
						'step' => '',
					),
				),
				array(
					'id'            => 'padding',
					'keywords'      => 'padding dimension',
					'label'         => __('Padding', 'lwwb'),
					'type'          => Control::DIMENSIONS,
					'group'         => 'advanced',
					'default'       => array(
						'desktop-top'    => '2',
						'desktop-right'  => '3',
						'desktop-bottom' => '4',
						'desktop-left'   => '5',
						'tablet-top'     => '',
						'tablet-right'   => 'auto',
						'tablet-bottom'  => '',
						'tablet-left'    => 'auto',
						'mobile-top'     => '',
						'mobile-right'   => '',
						'mobile-bottom'  => '',
						'mobile-left'    => '',

					),
					'device_config' => array(
						'desktop' => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'tablet'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'mobile'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
					),
					'input_attrs'   => array(
						'min'  => '',
						'max'  => '',
						'step' => '',
					),
				),
			),
		),
	);
}

// add style controls
public function add_style_group_controls()
{
	return array(
		array(
			'id'           => 'style',
			'label'        => __('Style', 'lwwb'),
			'type'         => Control::GROUP,
			'dependencies' => array(
				array(
					'control'  => 'lwwb_tab_control',
					'operator' => '===',
					'value'    => 'style',
				),
			),
			'fields'       => array(
				array(
					'id'            => 'margin',
					'keywords'      => 'margin, dimension, ',
					'label'         => __('Margin', 'lwwb'),
					'type'          => Control::DIMENSIONS,
					'default'       => array(
						'desktop-top'    => '2',
						'desktop-right'  => '3',
						'desktop-bottom' => '4',
						'desktop-left'   => '5',
						'tablet-top'     => '',
						'tablet-right'   => 'auto',
						'tablet-bottom'  => '',
						'tablet-left'    => 'auto',
						'mobile-top'     => '',
						'mobile-right'   => '',
						'mobile-bottom'  => '',
						'mobile-left'    => '',

					),
					'device_config' => array(
						'desktop' => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'tablet'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'mobile'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
					),
					'input_attrs'   => array(
						'min'  => '',
						'max'  => '',
						'step' => '',
					),
				),
				array(
					'id'            => 'padding',
					'keywords'      => 'padding dimension',
					'label'         => __('Padding', 'lwwb'),
					'type'          => Control::DIMENSIONS,
					'group'         => 'advanced',
					'default'       => array(
						'desktop-top'    => '2',
						'desktop-right'  => '3',
						'desktop-bottom' => '4',
						'desktop-left'   => '5',
						'tablet-top'     => '',
						'tablet-right'   => 'auto',
						'tablet-bottom'  => '',
						'tablet-left'    => 'auto',
						'mobile-top'     => '',
						'mobile-right'   => '',
						'mobile-bottom'  => '',
						'mobile-left'    => '',

					),
					'device_config' => array(
						'desktop' => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'tablet'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'mobile'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
					),
					'input_attrs'   => array(
						'min'  => '',
						'max'  => '',
						'step' => '',
					),
				),
			),
		),
	);
}

// add advanced controls
public function add_advanced_group_controls()
{
	return array(
		array(
			'id'           => 'advanced',
			'label'        => __('Advanced', 'lwwb'),
			'type'         => Control::GROUP,
			'dependencies' => array(
				array(
					'control'  => 'lwwb_tab_control',
					'operator' => '===',
					'value'    => 'advanced',
				),
			),
			'fields'       => array(
				array(
					'id'            => 'margin',
					'keywords'      => 'margin, dimension, ',
					'label'         => __('Margin', 'lwwb'),
					'type'          => Control::DIMENSIONS,
					'default'       => array(
						'desktop-top'    => '2',
						'desktop-right'  => '3',
						'desktop-bottom' => '4',
						'desktop-left'   => '5',
						'tablet-top'     => '',
						'tablet-right'   => 'auto',
						'tablet-bottom'  => '',
						'tablet-left'    => 'auto',
						'mobile-top'     => '',
						'mobile-right'   => '',
						'mobile-bottom'  => '',
						'mobile-left'    => '',

					),
					'device_config' => array(
						'desktop' => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'tablet'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'mobile'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
					),
					'input_attrs'   => array(
						'min'  => '',
						'max'  => '',
						'step' => '',
					),
				),
				array(
					'id'            => 'padding',
					'keywords'      => 'padding dimension',
					'label'         => __('Padding', 'lwwb'),
					'type'          => Control::DIMENSIONS,
					'group'         => 'advanced',
					'default'       => array(
						'desktop-top'    => '2',
						'desktop-right'  => '3',
						'desktop-bottom' => '4',
						'desktop-left'   => '5',
						'tablet-top'     => '',
						'tablet-right'   => 'auto',
						'tablet-bottom'  => '',
						'tablet-left'    => 'auto',
						'mobile-top'     => '',
						'mobile-right'   => '',
						'mobile-bottom'  => '',
						'mobile-left'    => '',

					),
					'device_config' => array(
						'desktop' => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'tablet'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'mobile'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
					),
					'input_attrs'   => array(
						'min'  => '',
						'max'  => '',
						'step' => '',
					),
				),

				array(
					'id'       => 'test-repeat-slider-control',
					'keywords' => 'slider, media',
					'label'    => __('Slider image', 'lwwb'),
					'type'     => Control::REPEATER,
					'default'  => array(
						array(
							'slide-image'   => array(
								'url' => '',
								'id'  => '',
							),
							'slide-icon'    => 'fa fa-facebook',
							'slide-heading' => __('Slide heading', 'lwwb'),
							'slide-content' => __('Hrml content', 'lwwb'),
						),
						array(
							'slide-image'   => array(
								'url' => '',
								'id'  => '',
							),
							'slide-icon'    => 'fa fa-youtube',
							'slide-heading' => __('Slide heading', 'lwwb'),
							'slide-content' => __('Hrml content', 'lwwb'),
						),
					),
					'fields'   => array(
						array(
							'id'       => 'slide-image',
							'keywords' => 'slider',
							'label'    => __('Slide image', 'lwwb'),
							'type'     => Control::MEDIA_UPLOAD,
							'default'  => array(
								'url' => '',
								'id'  => '',
							),
						),
						array(
							'id'       => 'slide-icon',
							'keywords' => 'slider icon',
							'label'    => __('Slide icon', 'lwwb'),
							'type'     => Control::ICON_PICKER,
							'default'  => '',
						),
						array(
							'id'         => 'slide-heading',
							'keywords'   => 'slider heading',
							'label'      => __('Slide Heading', 'lwwb'),
							'type'       => Control::TEXT,
							'input_type' => 'text',
							'default'    => '',
						),
						array(
							'id'       => 'slide-content',
							'keywords' => 'slider content',
							'label'    => __('Slide Content', 'lwwb'),
							'type'     => Control::TEXTAREA,
							'default'  => '',
						),
						array(
							'id'       => 'slide-content-WYSIWYG',
							'keywords' => 'slider WYSIWYG',
							'label'    => __('Slide WYSIWYG', 'lwwb'),
							'type'     => Control::WYSIWYG,
							'default'  => 'this is the default content',
						),
					),
				),
			),
		),
	);
}

// add background controls
public function add_background_group_controls()
{
	return array(
		array(
			'id'           => 'background',
			'label'        => __('Background', 'lwwb'),
			'type'         => Control::GROUP,
			'dependencies' => array(
				array(
					'control'  => 'lwwb_tab_control',
					'operator' => '===',
					'value'    => 'advanced',
				),
			),
			'fields'       => array(
				array(
					'id'         => 'image-background',
					'keywords'   => 'image img jpg png',
					'label'      => __('Image', 'lwwb'),
					'type'       => Control::MEDIA_UPLOAD,
					'media_type' => 'image',
					'default'    => array(
						'id'  => '',
						'url' => '',
					),
				),
				array(
					'id'      => 'position',
					'label'   => __('Image position', 'lwwb'),
					'type'    => Control::SELECT,
					'default' => 'left',
					'choices' => array(
						'center' => __('Center', 'lwwb'),
						'left'   => __('Left', 'lwwb'),
						'right'  => __('Right', 'lwwb'),
					),

				),
			),

		),
	);

}

// add border controls
public function add_border_group_controls()
{
	return array(
		array(
			'id'           => 'border-group',
			'label'        => __('Border', 'lwwb'),
			'type'         => Control::GROUP,
			'dependencies' => array(
				array(
					'control'  => 'lwwb_tab_control',
					'operator' => '===',
					'value'    => 'advanced',
				),
			),
			'fields'       => array(
				array(
					'id'          => 'border-state',
					'keywords'    => '',
					'label'       => '',
					'default'     => 'normal',
					'type'        => Control::BUTTON_SET,
					'description' => '',
					'choices'     => array(
						'normal' => __('Normal', 'lwwb'),
						'hover'  => __('Hover', 'lwwb'),
					),
				),
				array(
					'id'             => 'border-type',
					'label'          => __('Border type', 'lwwb'),
					'type'           => Control::SELECT,
					'control_layout' => 'inline',
					'default'        => 'none',
					'choices'        => array(
						'none'   => __('None', 'lwwb'),
						'solid'  => __('Solid', 'lwwb'),
						'double' => __('Double', 'lwwb'),
						'dotted' => __('Dotted', 'lwwb'),
						'dashed' => __('Dashed', 'lwwb'),
						'groove' => __('Groove', 'lwwb'),
					),

				),

				array(
					'id'            => 'border-width',
					'keywords'      => 'border width',
					'label'         => __('Border Width', 'lwwb'),
					'type'          => Control::DIMENSIONS,
					'default'       => array(
						'desktop-top'    => '',
						'desktop-right'  => '',
						'desktop-bottom' => '',
						'desktop-left'   => '',
						'tablet-top'     => '',
						'tablet-right'   => 'auto',
						'tablet-bottom'  => '',
						'tablet-left'    => 'auto',
						'mobile-top'     => '',
						'mobile-right'   => '',
						'mobile-bottom'  => '',
						'mobile-left'    => '',

					),
					'device_config' => array(
						'desktop' => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'tablet'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'mobile'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
					),
					'input_attrs'   => array(
						'min'  => '',
						'max'  => '',
						'step' => '',
					),
					'dependencies'  => array(
						array(
							'control'  => 'border-type',
							'operator' => '!==',
							'value'    => 'none',
						),
					),
				),
				array(
					'id'            => 'border-radius',
					'keywords'      => 'border radius',
					'label'         => __('Border Radius', 'lwwb'),
					'type'          => Control::DIMENSIONS,
					'default'       => array(
						// 'desktop-top'    => '2',
						// 'desktop-right'  => '3',
						// 'desktop-bottom' => '4',
						// 'desktop-left'   => '5',
						// 'tablet-top'     => '',
						// 'tablet-right'   => 'auto',
						// 'tablet-bottom'  => '',
						// 'tablet-left'    => 'auto',
						// 'mobile-top'     => '',
						// 'mobile-right'   => '',
						// 'mobile-bottom'  => '',
						// 'mobile-left'    => '',

					),
					'device_config' => array(
						'desktop' => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'tablet'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
						'mobile'  => array(
							'top'    => esc_html__('Top', 'lwwb'),
							'right'  => esc_html__('Right', 'lwwb'),
							'bottom' => esc_html__('Bottom', 'lwwb'),
							'left'   => esc_html__('Left', 'lwwb'),
						),
					),
					'input_attrs'   => array(
						'min'  => '',
						'max'  => '',
						'step' => '',
					),
					'unit'          => array(
						'px' => 'px',
						'%'  => '%',
					),
				),

				array(
					'id'           => 'border-color',
					'keywords'     => 'border color',
					// 'control_layout' => 'inline',
					'label'        => 'Border color',
					'type'         => Control::COLOR_PICKER,
					'description'  => '',
					'dependencies' => array(
						array(
							'control'  => 'border-state',
							'operator' => 'in',
							'value'    => array('normal'),
						),
						array(
							'control'  => 'border-type',
							'operator' => '!==',
							'value'    => 'none',
						),
					),
				),
			),
		),
	);

}

// add responsive controls
public function add_responsive_group_controls()
{
	return array();

}

// add custom_css controls
public function add_custom_css_group_controls()
{
	return array();

}