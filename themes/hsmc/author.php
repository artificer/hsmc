<?php
/**
 * The generic author template file.
 *
 * Displays information about a registered user
 * TODO: For HSMC, assiming Midwives and Doctors will have slightly different views
 * load the appropriate template file here e.g. author-doctor.php for doctros
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage HSMC
 * @since HSMC 0.1
 */

if(get_query_var('author_name')):
	$clinician = get_user_by('login', get_query_var('author_name'));
else:
	$clinician = get_user_by('id', get_query_var('author'));
endif;
$data = get_user_meta($clinician->ID);
Debug_Bar_Extender::instance()->trace_var($data);

get_header(); ?>
<?php 
	switch ($clinician->roles[0]) {
		case 'doctor':
			get_template_part('author', 'doctor');
			break;
		case 'midwife':
			get_template_part('author', 'midwife');
			break;
		default:
			# code...
			break;
	}
?>


<?php get_footer(); ?>
