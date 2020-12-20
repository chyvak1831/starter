<?php
/**
 * Comments setting in customizer
 *
 * @since starter 1.0
 */
$wp_customize->add_section(
	'comments_section',
	array(
		'title'    => 'Comments',
		'priority' => 3,
		'panel'    => 'woocommerce',
	)
);

// extended rating
$wp_customize->add_setting(
	'comment_extended_rating',
	array(
		'default'   => false,
		'type'      => 'theme_mod',
		'transport' => 'postMessage',
	)
);
$wp_customize->add_control(
	'comment_extended_rating',
	array(
		'section' => 'comments_section',
		'label'   => 'Extended rating',
		'type'    => 'checkbox',
	)
);

// low-rating modal
$wp_customize->add_setting(
	'comment_low_rating_modal',
	array(
		'default'   => false,
		'type'      => 'theme_mod',
		'transport' => 'postMessage',
	)
);
$wp_customize->add_control(
	'comment_low_rating_modal',
	array(
		'section' => 'comments_section',
		'label'   => 'Low-rating popup',
		'type'    => 'checkbox',
	)
);

// "Privacy Policy" checkbox
$wp_customize->add_setting(
	'comment_privacy',
	array(
		'default'   => false,
		'type'      => 'theme_mod',
		'transport' => 'postMessage',
	)
);
$wp_customize->add_control(
	'comment_privacy',
	array(
		'section' => 'comments_section',
		'label'   => '"Privacy Policy" checkbox',
		'type'    => 'checkbox',
	)
);

// recaptcha
$wp_customize->add_setting(
	'comment_recaptcha',
	array(
		'default'   => false,
		'type'      => 'theme_mod',
		'transport' => 'postMessage',
	)
);
$wp_customize->add_control(
	'comment_recaptcha',
	array(
		'section' => 'comments_section',
		'label'   => 'Recaptcha',
		'type'    => 'checkbox',
	)
);

// file
$wp_customize->add_setting(
	'comment_file',
	array(
		'default'   => false,
		'type'      => 'theme_mod',
		'transport' => 'postMessage',
	)
);
$wp_customize->add_control(
	'comment_file',
	array(
		'section' => 'comments_section',
		'label'   => 'File',
		'type'    => 'checkbox',
	)
);

// maximum amount of attached files
$wp_customize->add_setting(
	'comment_maximum_files',
	array(
		'default'   => '10',
		'type'      => 'theme_mod',
		'transport' => 'postMessage',
	)
);
$wp_customize->add_control(
	'comment_maximum_files',
	array(
		'section' => 'comments_section',
		'label'   => 'Maximum qty attached files',
		'type'    => 'number',
	)
);

// maximum weight of each attached file
$wp_customize->add_setting(
	'comment_maximum_weight',
	array(
		'default'   => '15',
		'type'      => 'theme_mod',
		'transport' => 'postMessage',
	)
);
$wp_customize->add_control(
	'comment_maximum_weight',
	array(
		'section' => 'comments_section',
		'label'   => 'Maximum weight attached file, MB',
		'type'    => 'number',
	)
);