<?php
/**
 * Envato Elements: Template Kits Import
 *
 * API for handling template kit imports
 *
 * @package Envato/Envato_Elements
 * @since 2.0.0
 */

namespace Envato_Elements\API;

use Envato_Elements\Backend\Template_Kits;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * API for handling template kit imports
 *
 * @since 2.0.0
 */
class Template_Kit_Import extends API {

	/**
	 * @return \WP_REST_Response
	 */
	public function fetch_all_installed_template_kits() {

		$installed_kits = Template_Kits::get_instance()->get_installed_template_kits();

		return $this->format_success( $installed_kits );
	}

	/**
	 * @param $request \WP_REST_Request
	 *
	 * @return \WP_REST_Response
	 */
	public function fetch_individual_templates( $request ) {

		$template_kit_id = $request->get_param( 'id' );
		if ( $template_kit_id === 'all' ) {
			// User is requesting templates from all kits.
			$all_template_data = [
				'id'           => 'all',
				'title'        => 'All Installed Kits',
				'requirements' => [],
				'templates'    => [],
			];
			$installed_kits    = Template_Kits::get_instance()->get_installed_template_kits();
			foreach ( $installed_kits as $installed_kit ) {
				$installed_kit_data = Template_Kits::get_instance()->get_installed_template_kit( $installed_kit['id'] );
				if ( $installed_kit_data && ! is_wp_error( $installed_kit_data ) ) {
					$all_template_data['templates'] = $all_template_data['templates'] + $installed_kit_data['templates'];
				}
			}
		} else {
			$template_kit_id = (int) $template_kit_id;

			$all_template_data = Template_Kits::get_instance()->get_installed_template_kit( $template_kit_id );
			if ( is_wp_error( $all_template_data ) ) {
				return $this->format_error(
					'fetchInstalledTemplateKit',
					'not_found',
					'Sorry this Template Kit was not found'
				);
			}
		}

		// Now we split the template data into groups.
		// This list of templates come from the "Template Kit Export" plugin:
		$template_types = [
			'single-page'         => __( 'Single: Page', 'template-kit-export' ),
			'single-home'         => __( 'Single: Home', 'template-kit-export' ),
			'single-post'         => __( 'Single: Post', 'template-kit-export' ),
			'single-product'      => __( 'Single: Product', 'template-kit-export' ),
			'single-404'          => __( 'Single: 404', 'template-kit-export' ),
			'archive-blog'        => __( 'Archive: Blog', 'template-kit-export' ),
			'archive-product'     => __( 'Archive: Product', 'template-kit-export' ),
			'archive-search'      => __( 'Archive: Search', 'template-kit-export' ),
			'archive-category'    => __( 'Archive: Category', 'template-kit-export' ),
			'section-header'      => __( 'Header', 'template-kit-export' ),
			'section-footer'      => __( 'Footer', 'template-kit-export' ),
			'section-popup'       => __( 'Popup', 'template-kit-export' ),
			'section-hero'        => __( 'Hero', 'template-kit-export' ),
			'section-about'       => __( 'About', 'template-kit-export' ),
			'section-faq'         => __( 'FAQ', 'template-kit-export' ),
			'section-contact'     => __( 'Contact', 'template-kit-export' ),
			'section-cta'         => __( 'Call to Action', 'template-kit-export' ),
			'section-team'        => __( 'Team', 'template-kit-export' ),
			'section-map'         => __( 'Map', 'template-kit-export' ),
			'section-features'    => __( 'Features', 'template-kit-export' ),
			'section-pricing'     => __( 'Pricing', 'template-kit-export' ),
			'section-testimonial' => __( 'Testimonial', 'template-kit-export' ),
			'section-product'     => __( 'Product', 'template-kit-export' ),
			'section-services'    => __( 'Services', 'template-kit-export' ),
			'section-stats'       => __( 'Stats', 'template-kit-export' ),
			'section-countdown'   => __( 'Countdown', 'template-kit-export' ),
			'section-portfolio'   => __( 'Portfolio', 'template-kit-export' ),
			'section-gallery'     => __( 'Gallery', 'template-kit-export' ),
			'section-logo-grid'   => __( 'Logo Grid', 'template-kit-export' ),
			'section-clients'     => __( 'Clients', 'template-kit-export' ),
			'section-other'       => __( 'Other', 'template-kit-export' ),
		];

		$templates_grouped = [];
		foreach ( $all_template_data['templates'] as $template_id => $template ) {
			$template_group = ! empty( $template['metadata'] ) && ! empty( $template['metadata']['template_type'] ) && $template['metadata']['template_type'] !== 'global-styles' ? $template['metadata']['template_type'] : false;
			if ( $template_group ) {
				if ( ! isset( $templates_grouped[ $template_group ] ) ) {
					$templates_grouped[ $template_group ] = [
						'title'     => isset( $template_types[ $template_group ] ) ? $template_types[ $template_group ] : $template_group,
						'templates' => [],
					];
				}
				$templates_grouped[ $template_group ]['templates'][] = $template;
			} else {
				// If something doesn't have a valid template type, remove it from the list.
				unset( $all_template_data['templates'][ $template_id ] );
			}
		}
		$all_template_data['templates']        = array_values( $all_template_data['templates'] );
		$all_template_data['templatesGrouped'] = array_values( $templates_grouped );

		// We report any missing default settings that are required for template kits.
		if ( ! isset( $all_template_data['requirements']['settings'] ) ) {
			$all_template_data['requirements']['settings'] = [];
		}
		// Check Elementor default colors and fonts are set.
		// Elementor stores the string 'yes' in the WordPress database if these options are active, and an empty string if these options are not active.
		$is_elementor_color_schemes_disabled_already      = get_option( 'elementor_disable_color_schemes' );
		$is_elementor_typography_schemes_disabled_already = get_option( 'elementor_disable_typography_schemes' );
		if ( $is_elementor_color_schemes_disabled_already !== 'yes' ) {
			$all_template_data['requirements']['settings'][] = [
				'name'         => 'Elementor default color schemes',
				'setting_name' => 'elementor_disable_color_schemes'
			];
		}
		if ( $is_elementor_typography_schemes_disabled_already !== 'yes' ) {
			$all_template_data['requirements']['settings'][] = [
				'name'         => 'Elementor default typography schemes',
				'setting_name' => 'elementor_disable_typography_schemes'
			];
		}

		return $this->format_success( $all_template_data );
	}

	/**
	 * @param $request \WP_REST_Request
	 *
	 * @return \WP_REST_Response
	 */
	public function import_single_template( $request ) {

		$template_kit_id = (int) $request->get_param( 'templateKitId' );
		$template_id     = (int) $request->get_param( 'templateId' );
		$import_again    = $request->get_param( 'importAgain' ) === 'true';

		try {
			$imported_template_data = Template_Kits::get_instance()->import_single_template( $template_kit_id, $template_id, $import_again );
			if ( is_wp_error( $imported_template_data ) ) {
				return $this->format_error(
					'importSingleTemplate',
					'generic_api_error',
					$imported_template_data->get_error_message()
				);
			}

			if ( $request->get_param( 'insertToPage' ) ) {
				// we have to return additional JSON data so Elementor can insert these widgets on the page.
				\Elementor\Plugin::$instance->editor->set_edit_mode( true );
				$db      = \Elementor\Plugin::$instance->db;
				$content = $db->get_builder( $imported_template_data['imported_template_id'] );
				if ( ! empty( $content ) ) {
					$content = \Elementor\Plugin::$instance->db->iterate_data( $content, function ( $element ) {
						$element['id'] = \Elementor\Utils::generate_random_string();

						return $element;
					} );
				}
				$imported_template_data['content'] = $content;
			}

			return $this->format_success( $imported_template_data );
		} catch ( \Exception $e ) {
			return $this->format_error(
				'importSingleTemplate',
				'generic_api_error',
				$e->getMessage()
			);
		}
	}

	public function register_api_endpoints() {
		$this->register_endpoint( 'fetchInstalledTemplateKits', [ $this, 'fetch_all_installed_template_kits' ] );
		$this->register_endpoint( 'fetchIndividualTemplates', [ $this, 'fetch_individual_templates' ] );
		$this->register_endpoint( 'importSingleTemplate', [ $this, 'import_single_template' ] );
	}
}
