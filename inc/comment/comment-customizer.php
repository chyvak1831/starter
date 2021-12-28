<?php
/**
 * Comments setting in customizer
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

/**
 * Add Comments section
 */
$wp_customize->add_section(
	'comments_section',
	array(
		'title'    => 'Comments',
		'priority' => 30,
		'panel'    => 'starter_theme_panel',
	)
);

/**
 * "Privacy Policy" checkbox
 */
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

/**
 * File
 */
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

/**
 * Maximum amount of attached files
 */
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

/**
 * Maximum weight of each attached file
 */
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
