<?php
/**
 * Plugin Name: My ACF Fields
 * Description: Custom fields for Projects using ACF.
 * Version: 1.0
 * Author: Your Name
 */

if( !defined('ABSPATH') ) exit;

function register_acf_fields() {
    if( function_exists('acf_add_local_field_group') ) {
        // error_log("✅ ACF đã được load!");
        acf_add_local_field_group(array(
            'key' => 'group_project_fields',
            'title' => 'Project Details',
            'fields' => array(
                array(
                    'key' => 'field_project_status',
                    'label' => 'Project Status',
                    'name' => 'project_status',
                    'type' => 'select',
                    'choices' => array(
                        'completed' => 'Completed',
                        'in_progress' => 'In Progress',
                        'planning' => 'Planning',
                        'pending' => 'Pending'
                    ),
                ),
                array(
                    'key' => 'field_project_type',
                    'label' => 'ProjectType',
                    'name' => 'project_type',
                    'type' => 'checkbox',
                    'choices' => array(
                        'personal' => 'Personal',
                        'group' => 'Group',
                    ),
                ),
                array(
                    'key' => 'field_project_duration',
                    'label' => 'Project Duration',
                    'name' => 'project_duration',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_software_used',
                    'label' => 'Software Used',
                    'name' => 'software_used',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_languages_used',
                    'label' => 'Languages Used',
                    'name' => 'languages_used',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_primary_roles',
                    'label' => 'Primary Role(s)',
                    'name' => 'primary_roles',
                    'type' => 'checkbox',
                    'choices' => array(
                        'developer' => 'Developer',
                        'designer' => 'Designer',
                        'manager' => 'Manager',
                    ),
                ),
                array(
                    'key' => 'field_description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'textarea',
                ),
                array(
                    'key' => 'field_teaser_trailer',
                    'label' => 'Teaser Trailer',
                    'name' => 'teaser_trailer',
                    'type' => 'url',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'projects',
                    ),
                ),
            ),
        ));
    }
}
