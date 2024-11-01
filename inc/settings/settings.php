<?php
/**
 * About WP COVID Schema page
 *
 * @package WP COVID Schema
 */

/**
 * Load About WP COVID Schema styles in the admin
 *
 * @since 1.0.0
 * @param string $hook The current admin page.
 */
if (!function_exists('wp_covid_schema_start_load_admin_scripts')) {
	function wp_covid_schema_start_load_admin_scripts( $hook ) {
		
		if ( ! ( $hook === 'toplevel_page_wp-covid-schema' || $hook === 'covid-19-schema_page_wp-covid-schema-plugin-settings') ) {
			return;
		}

		wp_enqueue_script( 'jquery-ui-datepicker' );

		wp_enqueue_script( 'wp-covid-schema-settings-script', plugins_url( 'settings/settings.js', dirname( __FILE__ ) ), array( 'jquery', 'jquery-ui-datepicker' ), '1.0.0', true );
		wp_register_style( 'wp-covid-schema-settings-style', plugins_url( 'settings/settings.css', dirname( __FILE__ ) ), false, '1.0.0' );

		wp_register_style( 'jquery-ui-datepicker-style', plugins_url( 'settings/jquery-ui.min.css', dirname( __FILE__ ) ), false, '1.10.4' );

		wp_enqueue_style( 'jquery-ui-datepicker-style' );
		wp_enqueue_style( 'wp-covid-schema-settings-style' );

	}
	add_action( 'admin_enqueue_scripts', 'wp_covid_schema_start_load_admin_scripts' );
}

if (!function_exists('wp_covid_schema_getting_started_menu')) {
	function wp_covid_schema_getting_started_menu() {

		add_menu_page(
			__( 'COVID-19 Schema', 'wp-covid-schema' ),
			__( 'COVID-19 Schema', 'wp-covid-schema' ),
			'manage_options',
			'wp-covid-schema',
			'wp_covid_schema_getting_started_page',
			'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDIzLjEuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCAzNSAzNSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMzUgMzU7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbDojMDA0QUMwO30KPC9zdHlsZT4KPGc+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMTYsMTUuOGMtMC41LDAtMC44LDAuMy0wLjgsMC43YzAsMC40LDAuNCwwLjcsMC44LDAuN2MwLjUsMCwwLjgtMC4zLDAuOC0wLjdDMTYuOCwxNi4xLDE2LjUsMTUuOCwxNiwxNS44eiIKCQkvPgoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTE4LjUsMTUuMWMwLjIsMC4xLDAuMywwLjIsMC40LDAuNGMwLjEsMC4xLDAuMiwwLjEsMC4zLDAuMWMwLjItMC4yLDAuMS0wLjQsMC0wLjZjMCwwLTAuMS0wLjEtMC4xLTAuMQoJCWMwLDAtMC4xLTAuMS0wLjEtMC4xYzAsMC0wLjEtMC4xLTAuMS0wLjFjMCwwLTAuMS0wLjEtMC4xLTAuMWMtMC42LTAuMy0xLjMtMC41LTItMC4zYzAsMC0wLjEsMC0wLjEsMC4xYzAsMC0wLjEsMC4xLTAuMSwwLjEKCQljMCwwLjEsMC4xLDAuMSwwLjEsMC4xYzAuNiwwLjEsMS4zLDAuMSwxLjcsMC40QzE4LjQsMTUuMSwxOC41LDE1LjEsMTguNSwxNS4xeiIvPgoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTE4LjcsMTguN2MwLTAuMi0wLjItMC4zLTAuNC0wLjNjLTAuMiwwLTAuNCwwLjEtMC40LDAuM2MwLDAuMiwwLjIsMC4zLDAuNCwwLjNDMTguNiwxOSwxOC43LDE4LjgsMTguNywxOC43egoJCSIvPgoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTIxLjMsMTcuOGMwLjEtMC4xLDAuMS0wLjMsMC4xLTAuNGMwLTAuNC0wLjItMC43LTAuNC0xYzAsMCwwLDAtMC4xLDBjLTAuMSwwLTAuMS0wLjEtMC4yLDAKCQljMC4yLDAuNSwwLjQsMC45LDAuNCwxLjVDMjEuMiwxNy44LDIxLjMsMTcuOCwyMS4zLDE3Ljh6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMTEsMjcuNWMtMC4xLTAuMS0wLjItMC4xLTAuNC0wLjFjLTAuMSwwLTAuMiwwLjEtMC40LDAuM2MwLDAsMCwwLDAsMGwwLjcsMC41YzAsMCwwLDAsMCwwCgkJQzExLjMsMjcuOSwxMS4zLDI3LjcsMTEsMjcuNXoiLz4KCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xNi45LDMwLjJjLTAuNCwwLTAuNiwwLjEtMC43LDAuNGMwLDAuMSwwLDAuMiwwLjEsMC4yYzAuMSwwLjEsMC4xLDAuMSwwLjIsMC4xYzAuMiwwLDAuMywwLDAuNC0wLjEKCQljMC4xLTAuMSwwLjItMC4yLDAuMi0wLjRsMC0wLjFjMCwwLDAsMCwwLDBMMTYuOSwzMC4yeiIvPgoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTEwLjEsOS43YzAuNC0wLjQsMC4zLTAuOC0wLjItMS40QzkuNCw3LjcsOSw3LjYsOC42LDhDOC4yLDguNCw4LjIsOC44LDguNyw5LjRTOS43LDEwLjEsMTAuMSw5Ljd6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMTcuNSwwLjVjLTkuNCwwLTE3LDcuNi0xNywxN3M3LjYsMTcsMTcsMTdjOS40LDAsMTctNy42LDE3LTE3UzI2LjksMC41LDE3LjUsMC41eiBNMjkuMiwxMC4zCgkJYzAuNCwwLjEsMC43LDAuNCwwLjksMC45YzAuMiwwLjQsMC4zLDAuOSwwLjIsMS4zYy0wLjEsMC40LTAuNSwwLjctMSwxYy0xLjQsMC44LTIuNCwwLjYtMy0wLjVjLTAuMS0wLjItMC4yLTAuNC0wLjMtMC42CgkJYzAtMC4xLDAtMC4yLDAtMC4zczAuMS0wLjEsMC4yLTAuMmwwLjItMC4xYzAuMSwwLDAuMSwwLDAuMiwwYzAuMSwwLDAuMSwwLjEsMC4xLDAuMmMwLjEsMC4yLDAuMSwwLjQsMC4yLDAuNgoJCWMwLjMsMC41LDAuNiwwLjYsMS4xLDAuNGMwLDAsMCwwLDAsMGwwLDBjLTAuMi0wLjEtMC40LTAuMy0wLjUtMC42Yy0wLjQtMC44LTAuMi0xLjUsMC42LTEuOUMyOC41LDEwLjIsMjguOSwxMC4yLDI5LjIsMTAuM3oKCQkgTTMwLjUsMTcuMmMwLDAuNC0wLjMsMC42LTAuNiwwLjZzLTAuNi0wLjMtMC42LTAuNnMwLjMtMC42LDAuNi0wLjZTMzAuNSwxNi44LDMwLjUsMTcuMnogTTI3LDIzYzAsMC4xLDAsMC4xLDAsMC4ybC0wLjEsMC4xCgkJYzAsMC4xLTAuMSwwLjEtMC4yLDAuMWMtMC4xLDAtMC4xLDAtMC4yLDBsMCwwYy0wLjEsMC0wLjEtMC4xLTAuMS0wLjJjMC0wLjEsMC0wLjEsMC0wLjJsMC4xLTAuMWMwLTAuMSwwLjEtMC4xLDAuMi0wLjEKCQljMC4xLDAsMC4xLDAsMC4yLDBsMCwwQzI3LDIyLjgsMjcsMjIuOSwyNywyM3ogTTI0LjQsMTAuMWwxLjctMS45bDAsMGwtMS0wLjFjLTAuMSwwLTAuMSwwLTAuMS0wLjFjMC0wLjEsMC0wLjEsMC0wLjJsMC40LTAuNAoJCWMwLjEtMC4yLDAuMy0wLjIsMC41LTAuMmwwLjYsMC4xYzAuMiwwLDAuNCwwLjEsMC41LDAuM2wwLjQsMC40QzI3LjcsOCwyNy43LDgsMjcuNyw4LjFjMCwwLjEsMCwwLjItMC4xLDAuMmwtMi4zLDIuNQoJCWMtMC4xLDAuMS0wLjEsMC4xLTAuMiwwLjFjLTAuMSwwLTAuMiwwLTAuMi0wLjFsLTAuNC0wLjRjLTAuMS0wLjEtMC4xLTAuMS0wLjEtMC4yQzI0LjMsMTAuMiwyNC40LDEwLjEsMjQuNCwxMC4xeiBNMjEuOCw3CgkJbDAuMS0wLjJjMC0wLjEsMC4xLTAuMSwwLjItMC4yYzAuMSwwLDAuMiwwLDAuMiwwbDEuMiwwLjZjMC4xLDAsMC4xLDAuMSwwLjIsMC4yYzAsMC4xLDAsMC4yLDAsMC4ybC0wLjEsMC4yCgkJYzAsMC4xLTAuMSwwLjEtMC4yLDAuMmMtMC4xLDAtMC4yLDAtMC4yLDBsLTEuMi0wLjZjLTAuMSwwLTAuMS0wLjEtMC4yLTAuMkMyMS43LDcuMiwyMS43LDcuMSwyMS44LDd6IE0xOC4xLDQKCQljMC0wLjEsMC4xLTAuMiwwLjEtMC4yYzAuMS0wLjEsMC4xLTAuMSwwLjItMC4xYzAuMywwLDAuNiwwLDAuOSwwLjFjMC43LDAuMSwxLjIsMC40LDEuNSwwLjhjMC4zLDAuNCwwLjQsMC45LDAuMywxLjYKCQljLTAuMSwwLjctMC40LDEuMi0wLjgsMS41cy0xLDAuNC0xLjYsMC4zYy0wLjMsMC0wLjYtMC4xLTAuOS0wLjJjLTAuMSwwLTAuMi0wLjEtMC4yLTAuMWMwLTAuMS0wLjEtMC4yLTAuMS0wLjNMMTguMSw0eiBNMTUuMyw0CgkJYzAuMS0wLjEsMC4xLTAuMSwwLjItMC4xbDAuNi0wLjFjMC4xLDAsMC4yLDAsMC4yLDAuMUMxNi40LDMuOSwxNi40LDQsMTYuNCw0bDAuNCwzLjRjMCwwLjEsMCwwLjItMC4xLDAuMgoJCWMtMC4xLDAuMS0wLjEsMC4xLTAuMiwwLjFMMTYsNy45Yy0wLjEsMC0wLjIsMC0wLjItMC4xYy0wLjEtMC4xLTAuMS0wLjEtMC4xLTAuMmwtMC40LTMuNEMxNS4yLDQuMSwxNS4yLDQsMTUuMyw0eiBNMTAuNyw1LjMKCQlsMC41LTAuMmMwLjEsMCwwLjIsMCwwLjMsMHMwLjIsMC4xLDAuMiwwLjJsMS42LDIuM2MwLDAsMCwwLDAsMGMwLDAsMCwwLDAsMGwtMC40LTIuN2MwLTAuMSwwLTAuMiwwLTAuM2MwLTAuMSwwLjEtMC4xLDAuMi0wLjIKCQlsMC41LTAuMmMwLjEsMCwwLjEsMCwwLjIsMGMwLjEsMCwwLjEsMC4xLDAuMSwwLjJMMTQuMiw4YzAsMC4xLDAsMC4yLTAuMSwwLjNjMCwwLjEtMC4xLDAuMS0wLjIsMC4ybC0wLjUsMC4yYy0wLjEsMC0wLjIsMC0wLjMsMAoJCWMtMC4xLDAtMC4yLTAuMS0wLjItMC4xbC0yLjMtMi44YzAtMC4xLTAuMS0wLjEsMC0wLjJDMTAuNiw1LjQsMTAuNiw1LjQsMTAuNyw1LjN6IE03LjksNy4zYzAuNC0wLjQsMC45LTAuNiwxLjQtMC41CgkJYzAuNSwwLDEsMC4zLDEuNCwwLjhjMC40LDAuNSwwLjYsMSwwLjYsMS41YzAsMC41LTAuMiwxLTAuNywxLjRDMTAuMywxMC44LDkuOCwxMSw5LjMsMTFjLTAuNSwwLTEtMC4zLTEuNC0wLjgKCQljLTAuNC0wLjUtMC42LTEtMC42LTEuNUM3LjMsOC4yLDcuNSw3LjcsNy45LDcuM3ogTTUsMTFjMC4xLTAuMiwwLjMtMC41LDAuNC0wLjdjMC4xLTAuMSwwLjEtMC4xLDAuMi0wLjFjMC4xLDAsMC4yLDAsMC4zLDAKCQlsMC4zLDAuMWMwLjEsMCwwLjEsMC4xLDAuMSwwLjJjMCwwLjEsMCwwLjEtMC4xLDAuMmMtMC4yLDAuMi0wLjMsMC40LTAuNCwwLjZjLTAuMSwwLjMtMC4yLDAuNS0wLjEsMC44YzAuMSwwLjIsMC4zLDAuNSwwLjcsMC42CgkJYzAuMywwLjIsMC42LDAuMiwwLjksMC4yYzAuMy0wLjEsMC41LTAuMiwwLjYtMC41YzAuMS0wLjIsMC4yLTAuNCwwLjItMC42YzAtMC4xLDAuMS0wLjEsMC4xLTAuMmMwLjEsMCwwLjEsMCwwLjIsMGwwLjMsMC4xCgkJYzAuMSwwLDAuMSwwLjEsMC4yLDAuMmMwLDAuMSwwLDAuMiwwLDAuM2MtMC4xLDAuMi0wLjIsMC41LTAuMywwLjdjLTAuMywwLjYtMC43LDAuOS0xLjIsMS4xYy0wLjUsMC4xLTEsMC4xLTEuNi0wLjMKCQljLTAuNi0wLjMtMS0wLjctMS4xLTEuMkM0LjcsMTIsNC43LDExLjUsNSwxMXogTTUuMiwxNi41YzAuNCwwLDAuNiwwLjMsMC42LDAuNnMtMC4zLDAuNi0wLjYsMC42cy0wLjYtMC4zLTAuNi0wLjYKCQlTNC44LDE2LjUsNS4yLDE2LjV6IE00LjUsMjIuNGMtMC4xLTAuMi0wLjEtMC40LTAuMS0wLjdjMC0wLjEsMC0wLjEsMC4xLTAuMmMwLTAuMSwwLjEtMC4xLDAuMi0wLjFsMC4xLDBjMC4xLDAsMC4xLDAsMC4xLDAKCQljMCwwLDAuMSwwLjEsMC4xLDAuMWMwLDAuMiwwLDAuNCwwLjEsMC42YzAuMSwwLjQsMC4zLDAuNSwwLjYsMC40YzAuMSwwLDAuMi0wLjEsMC4yLTAuMmMwLTAuMSwwLjEtMC4yLDAuMS0wLjQKCQljMC0wLjQsMC0wLjcsMC4xLTAuOWMwLjEtMC4yLDAuMy0wLjQsMC41LTAuNGMwLjMtMC4xLDAuNS0wLjEsMC43LDBjMC4yLDAuMSwwLjQsMC4zLDAuNSwwLjZjMC4xLDAuMywwLjIsMC41LDAuMiwwLjcKCQljMCwwLjEsMCwwLjEtMC4xLDAuMmMwLDAuMS0wLjEsMC4xLTAuMiwwLjFsMCwwYy0wLjEsMC0wLjEsMC0wLjIsMGMwLDAtMC4xLTAuMS0wLjEtMC4xYzAtMC4yLDAtMC41LTAuMS0wLjcKCQljLTAuMS0wLjEtMC4xLTAuMi0wLjItMC4zYy0wLjEsMC0wLjItMC4xLTAuMywwYy0wLjIsMC4xLTAuMywwLjMtMC4zLDAuNmMwLDAuNCwwLDAuNy0wLjEsMC45QzYuMiwyMi45LDYsMjMsNS44LDIzLjEKCQlDNS4yLDIzLjMsNC43LDIzLjEsNC41LDIyLjR6IE02LjMsMjVjMC4xLDAuMSwwLjIsMC4yLDAuMiwwLjNjMCwwLDAuMSwwLjEsMC4xLDAuMWMwLDAuMSwwLDAuMS0wLjEsMC4xYy0wLjEsMC0wLjEsMC4xLTAuMiwwCgkJYy0wLjEsMC0wLjEsMC0wLjItMC4xQzYsMjUuNCw2LDI1LjMsNS45LDI1LjFjLTAuMi0wLjMtMC4zLTAuNi0wLjItMC45YzAuMS0wLjMsMC4zLTAuNSwwLjYtMC43YzAuMy0wLjIsMC42LTAuMywwLjktMC4yCgkJYzAuMywwLjEsMC41LDAuMiwwLjcsMC41QzgsMjMuOSw4LDI0LjEsOC4xLDI0LjJjMCwwLjEsMCwwLjEsMCwwLjJTOC4xLDI0LjUsOCwyNC42Yy0wLjEsMC0wLjEsMC0wLjIsMGMtMC4xLDAtMC4xLTAuMS0wLjEtMC4xCgkJYzAtMC4xLTAuMS0wLjItMC4yLTAuM2MtMC4xLTAuMi0wLjItMC4yLTAuNC0wLjNjLTAuMiwwLTAuMywwLjEtMC42LDAuMmMtMC4yLDAuMS0wLjQsMC4zLTAuNCwwLjRDNi4yLDI0LjYsNi4yLDI0LjgsNi4zLDI1egoJCSBNOC42LDI3LjhjMCwwLTAuMSwwLjEtMC4yLDAuMWMtMC4xLDAtMC4xLDAtMC4yLTAuMWwtMC4xLTAuMWMwLDAtMC4xLTAuMS0wLjEtMC4yYzAtMC4xLDAtMC4xLDAuMS0wLjJsMC43LTAuNwoJCWMwLjItMC4yLDAuMy0wLjMsMC4zLTAuNGMwLTAuMSwwLTAuMi0wLjEtMC4zYy0wLjEtMC4xLTAuMi0wLjEtMC40LTAuMXMtMC4zLDAtMC40LDAuMWwtMC44LDAuOGMwLDAtMC4xLDAuMS0wLjIsMC4xCgkJYy0wLjEsMC0wLjEsMC0wLjItMC4xbC0wLjEtMC4xYzAsMC0wLjEtMC4xLTAuMS0wLjJjMC0wLjEsMC0wLjEsMC4xLTAuMmwyLTJjMCwwLDAuMS0wLjEsMC4yLTAuMWMwLjEsMCwwLjEsMCwwLjIsMC4xbDAuMSwwLjEKCQljMCwwLDAuMSwwLjEsMC4xLDAuMmMwLDAuMSwwLDAuMS0wLjEsMC4ybC0wLjcsMC43YzAsMCwwLDAsMCwwYzAsMCwwLDAsMCwwYzAuMywwLDAuNSwwLjEsMC43LDAuM2MwLjIsMC4yLDAuMywwLjQsMC4yLDAuNgoJCWMwLDAuMi0wLjIsMC40LTAuNCwwLjdMOC42LDI3Ljh6IE0xMS41LDI4LjdjMCwwLjEtMC4xLDAuMS0wLjIsMC4xYy0wLjEsMC0wLjEsMC0wLjIsMGwtMS0wLjdjMCwwLDAsMCwwLDAKCQlDMTAsMjguMiwxMCwyOC40LDEwLDI4LjVzMC4yLDAuMywwLjMsMC40YzAuMSwwLjEsMC4zLDAuMSwwLjQsMC4yYzAuMSwwLDAuMSwwLjEsMC4xLDAuMWMwLDAuMSwwLDAuMSwwLDAuMmMwLDAuMS0wLjEsMC4xLTAuMSwwLjEKCQljLTAuMSwwLTAuMSwwLTAuMiwwYy0wLjItMC4xLTAuMy0wLjEtMC41LTAuMmMtMC4zLTAuMi0wLjUtMC41LTAuNi0wLjhjLTAuMS0wLjMsMC0wLjYsMC4yLTAuOWMwLjItMC4zLDAuNS0wLjUsMC43LTAuNgoJCWMwLjMtMC4xLDAuNiwwLDAuOSwwLjJDMTEuOCwyNy41LDExLjksMjgsMTEuNSwyOC43eiBNMTUuMSwyOS43bC0wLjQsMS4yYzAsMC4xLTAuMSwwLjEtMC4xLDAuMWMtMC4xLDAtMC4xLDAtMC4yLDBsLTAuMSwwCgkJYy0wLjEsMC0wLjEtMC4xLTAuMS0wLjFjMC0wLjEsMC0wLjEsMC0wLjJsMC40LTEuMWMwLjEtMC4yLDAuMS0wLjQsMC4xLTAuNGMwLTAuMS0wLjEtMC4xLTAuMi0wLjJjLTAuMSwwLTAuMiwwLTAuMywwCgkJYy0wLjEsMC0wLjIsMC4xLTAuMiwwLjJsLTAuNCwxLjNjMCwwLjEtMC4xLDAuMS0wLjEsMC4xYy0wLjEsMC0wLjEsMC0wLjIsMGwtMC4xLDBjLTAuMSwwLTAuMS0wLjEtMC4xLTAuMWMwLTAuMSwwLTAuMSwwLTAuMgoJCWwwLjQtMS4xYzAuMS0wLjIsMC4xLTAuMywwLjEtMC40YzAtMC4xLTAuMS0wLjEtMC4yLTAuMmMtMC4xLDAtMC4yLDAtMC4zLDBjLTAuMSwwLTAuMiwwLjEtMC4yLDAuMmwtMC40LDEuMwoJCWMwLDAuMS0wLjEsMC4xLTAuMSwwLjFjLTAuMSwwLTAuMSwwLTAuMiwwbC0wLjEsMGMtMC4xLDAtMC4xLTAuMS0wLjEtMC4xczAtMC4xLDAtMC4ybDAuNi0xLjdjMC0wLjEsMC4xLTAuMSwwLjEtMC4xCgkJYzAuMSwwLDAuMSwwLDAuMiwwbDAuMSwwYzAuMSwwLDAuMSwwLjEsMC4xLDAuMWMwLDAuMSwwLDAuMSwwLDAuMmwwLDBjMCwwLDAsMCwwLDBjMCwwLDAsMCwwLDBjMC4yLTAuMSwwLjUtMC4yLDAuNy0wLjEKCQljMC4xLDAsMC4yLDAuMSwwLjMsMC4yYzAuMSwwLjEsMC4xLDAuMiwwLjEsMC4zYzAsMCwwLDAsMCwwYzAsMCwwLDAsMCwwYzAuMy0wLjIsMC41LTAuMiwwLjctMC4xYzAuMiwwLjEsMC40LDAuMiwwLjQsMC40CgkJQzE1LjIsMjkuMiwxNS4yLDI5LjQsMTUuMSwyOS43eiBNMTcuNywzMS4xYzAsMC4xLDAsMC4xLTAuMSwwLjJjLTAuMSwwLTAuMSwwLjEtMC4yLDAuMWwwLDBjLTAuMSwwLTAuMSwwLTAuMi0wLjEKCQljMC0wLjEtMC4xLTAuMS0wLjEtMC4ybDAtMC4xYzAsMCwwLDAsMCwwYzAsMCwwLDAsMCwwYy0wLjIsMC4yLTAuNSwwLjMtMC44LDAuM2MtMC4yLDAtMC40LTAuMS0wLjUtMC4yYy0wLjEtMC4xLTAuMi0wLjMtMC4yLTAuNQoJCWMwLTAuMywwLjEtMC41LDAuMy0wLjZjMC4yLTAuMSwwLjUtMC4yLDAuOS0wLjJsMC4yLDBjMCwwLDAsMCwwLDBsMCwwYzAtMC4xLDAtMC4yLTAuMS0wLjNjLTAuMS0wLjEtMC4yLTAuMS0wLjMtMC4xCgkJYy0wLjIsMC0wLjQsMC0wLjYsMC4xYy0wLjEsMC0wLjEsMC0wLjEsMGMwLDAtMC4xLTAuMS0wLjEtMC4xYzAtMC4xLDAtMC4xLDAuMS0wLjJjMC0wLjEsMC4xLTAuMSwwLjItMC4xYzAuMiwwLDAuNC0wLjEsMC42LDAKCQljMC40LDAsMC42LDAuMSwwLjgsMC4zYzAuMSwwLjEsMC4yLDAuNCwwLjIsMC43TDE3LjcsMzEuMXogTTE4LjYsMjUuNGMtMC40LDAtMC43LTAuMy0wLjctMC43YzAtMC4zLDAuMi0wLjUsMC40LTAuNwoJCWMtMC4xLTAuMy0wLjItMC42LTAuMi0xYy0wLjIsMC0wLjUsMC4xLTAuNywwLjFjLTEsMC0xLjktMC4zLTIuNi0wLjhjLTAuMSwwLjEtMC4yLDAuMi0wLjQsMC4zYzAuMSwwLjEsMC4xLDAuMiwwLjEsMC4zCgkJYzAsMC4zLTAuMywwLjYtMC42LDAuNnMtMC42LTAuMy0wLjYtMC42czAuMy0wLjYsMC42LTAuNmMwLjEsMCwwLjIsMCwwLjIsMGMwLDAsMCwwLDAsMGMwLjEtMC4xLDAuMi0wLjIsMC4yLTAuMwoJCWMtMC45LTAuNy0xLjUtMS44LTEuNy0zYy0wLjIsMC0wLjUtMC4xLTAuOC0wLjFjLTAuMiwwLjUtMC44LDAuOC0xLjQsMC42Yy0wLjYtMC4yLTAuOS0wLjgtMC43LTEuNGMwLjItMC42LDAuOC0wLjksMS40LTAuNwoJCWMwLjQsMC4xLDAuNywwLjUsMC43LDAuOGMwLjItMC4xLDAuNC0wLjEsMC42LTAuMmMwLTAuOCwwLjMtMS41LDAuNi0yLjFjLTAuMi0wLjMtMC40LTAuNi0wLjctMC45Yy0wLjEsMC0wLjEsMC0wLjIsMAoJCWMtMC4zLDAtMC41LTAuMi0wLjUtMC41YzAtMC4zLDAuMi0wLjUsMC41LTAuNWMwLjMsMCwwLjUsMC4yLDAuNSwwLjVjMCwwLjEsMCwwLjItMC4xLDAuMmMwLjMsMC4yLDAuNSwwLjQsMC44LDAuNgoJCWMwLjktMS4xLDIuMi0xLjksMy44LTEuOWMwLjQsMCwwLjcsMCwxLjEsMC4xYzAuMS0wLjIsMC4yLTAuNCwwLjMtMC43Yy0wLjItMC4yLTAuNC0wLjUtMC40LTAuOWMwLTAuNiwwLjUtMS4yLDEuMi0xLjIKCQljMC42LDAsMS4yLDAuNSwxLjIsMS4yYzAsMC42LTAuNSwxLjItMS4yLDEuMmMtMC4xLDAtMC4xLDAtMC4yLDBjMCwwLDAsMCwwLDBjMCwwLjItMC4xLDAuNC0wLjEsMC42YzEuMSwwLjUsMi4xLDEuNCwyLjYsMi41CgkJYzAuMi0wLjEsMC4zLTAuMSwwLjUtMC4yYzAtMC4xLTAuMS0wLjItMC4xLTAuM2MwLTAuNSwwLjQtMC45LDAuOS0wLjljMC41LDAsMC45LDAuNCwwLjksMC45YzAsMC41LTAuNCwwLjktMC45LDAuOQoJCWMtMC4yLDAtMC41LTAuMS0wLjYtMC4yYy0wLjIsMC4xLTAuNCwwLjItMC41LDAuM2MwLjEsMC40LDAuMiwwLjksMC4yLDEuNGMwLDAuNC0wLjEsMC44LTAuMSwxLjJjMC4yLDAuMSwwLjUsMC4xLDAuNywwLjIKCQljMC4yLTAuNCwwLjctMC43LDEuMi0wLjdjMC44LDAsMS40LDAuNiwxLjQsMS40YzAsMC44LTAuNiwxLjQtMS40LDEuNGMtMC44LDAtMS40LTAuNi0xLjQtMS40YzAsMCwwLDAsMC0wLjFjLTAuMywwLTAuNSwwLTAuOC0wLjEKCQljLTAuNiwxLjMtMS43LDIuMy0zLDIuN2MwLDAuMywwLDAuNywwLDFjMC40LDAsMC43LDAuMywwLjcsMC43QzE5LjMsMjUuMSwxOSwyNS40LDE4LjYsMjUuNHogTTIxLjgsMjkuMmMtMC4yLDAuMi0wLjQsMC40LTAuOCwwLjUKCQljLTAuMSwwLTAuMiwwLjEtMC40LDAuMWMwLDAsMCwwLDAsMGwwLjIsMC44YzAsMC4xLDAsMC4xLDAsMC4yYzAsMC4xLTAuMSwwLjEtMC4yLDAuMWwtMC4xLDBjLTAuMSwwLTAuMSwwLTAuMiwwCgkJYy0wLjEsMC0wLjEtMC4xLTAuMS0wLjJsLTAuNy0yLjZjMC0wLjEsMC0wLjEsMC0wLjJjMC0wLjEsMC4xLTAuMSwwLjEtMC4xYzAuMi0wLjEsMC41LTAuMiwwLjctMC4yYzAuNC0wLjEsMC44LTAuMSwxLDAKCQljMC4zLDAuMSwwLjQsMC4zLDAuNSwwLjdDMjIsMjguNywyMS45LDI5LDIxLjgsMjkuMnogTTIzLjYsMjkuOUwyMy41LDMwYy0wLjEsMC0wLjEsMC0wLjIsMGMtMC4xLDAtMC4xLTAuMS0wLjEtMC4xbC0xLjMtMi42CgkJYzAtMC4xLDAtMC4xLDAtMC4yQzIyLDI3LDIyLDI3LDIyLjEsMjdsMC4xLTAuMWMwLjEsMCwwLjEsMCwwLjIsMHMwLjEsMC4xLDAuMSwwLjFsMS4zLDIuNmMwLDAuMSwwLDAuMSwwLDAuMgoJCUMyMy44LDI5LjksMjMuNywyOS45LDIzLjYsMjkuOXogTTI2LjMsMjguM0wyNi4zLDI4LjNjLTAuMSwwLjEtMC4yLDAuMS0wLjIsMC4xYy0wLjEsMC0wLjEsMC0wLjItMC4xbDAsMGMwLDAsMCwwLDAsMGMwLDAsMCwwLDAsMAoJCWMwLDAuMy0wLjIsMC41LTAuNCwwLjdjLTAuMiwwLjItMC40LDAuMi0wLjYsMC4yYy0wLjIsMC0wLjQtMC4yLTAuNi0wLjVsLTAuNy0wLjljMC0wLjEtMC4xLTAuMSwwLTAuMmMwLTAuMSwwLTAuMSwwLjEtMC4ybDAuMSwwCgkJYzAuMSwwLDAuMS0wLjEsMC4yLDBjMC4xLDAsMC4xLDAsMC4yLDAuMWwwLjcsMC45YzAuMSwwLjIsMC4yLDAuMywwLjMsMC4zYzAuMSwwLDAuMiwwLDAuMy0wLjFjMC4xLTAuMSwwLjItMC4yLDAuMi0wLjMKCQljMC0wLjEsMC0wLjMtMC4xLTAuNGwtMC43LTAuOWMwLTAuMS0wLjEtMC4xLDAtMC4yYzAtMC4xLDAtMC4xLDAuMS0wLjJsMC4xLTAuMWMwLjEsMCwwLjEtMC4xLDAuMiwwYzAuMSwwLDAuMSwwLDAuMiwwLjFsMS4xLDEuNQoJCWMwLDAuMSwwLjEsMC4xLDAsMC4yQzI2LjQsMjguMiwyNi4zLDI4LjIsMjYuMywyOC4zeiBNMjguNiwyNy40Yy0wLjEsMC4xLTAuMiwwLjItMC4zLDAuM2MtMC4xLDAtMC4xLDAuMS0wLjIsMC4xCgkJYy0wLjEsMC0wLjEsMC0wLjItMC4xYzAsMC0wLjEtMC4xLTAuMS0wLjFzMC0wLjEsMC4xLTAuMWMwLjEtMC4xLDAuMi0wLjIsMC4zLTAuM2MwLjEtMC4yLDAuMi0wLjMsMC4yLTAuNWMwLTAuMi0wLjEtMC4zLTAuMy0wLjUKCQlMMjgsMjYuMWMwLDAsMCwwLDAsMGMwLDAsMCwwLDAsMGMwLDAuMy0wLjEsMC41LTAuMiwwLjdjLTAuMiwwLjItMC40LDAuMy0wLjcsMC4zcy0wLjUtMC4xLTAuOC0wLjRzLTAuNC0wLjUtMC41LTAuNwoJCWMwLTAuMywwLTAuNSwwLjItMC43YzAuMS0wLjEsMC4yLTAuMiwwLjMtMC4yczAuMi0wLjEsMC40LTAuMWMwLDAsMCwwLDAsMGMwLDAsMCwwLDAsMGwwLDBjLTAuMSwwLTAuMS0wLjEtMC4xLTAuMgoJCWMwLTAuMSwwLTAuMSwwLjEtMC4ybDAsMGMwLTAuMSwwLjEtMC4xLDAuMi0wLjFjMC4xLDAsMC4xLDAsMC4yLDAuMWwxLjQsMS4yQzI5LjEsMjYuMywyOS4xLDI2LjgsMjguNiwyNy40eiBNMjkuNCwyNC42TDI5LjQsMjQuNgoJCWMtMC4xLDAuMi0wLjEsMC4yLTAuMiwwLjJjLTAuMSwwLTAuMSwwLTAuMiwwbC0xLjYtMC45Yy0wLjEsMC0wLjEtMC4xLTAuMS0wLjJjMC0wLjEsMC0wLjEsMC0wLjJsMC4xLTAuMWMwLTAuMSwwLjEtMC4xLDAuMi0wLjEKCQljMC4xLDAsMC4xLDAsMC4yLDBsMS42LDAuOWMwLjEsMCwwLjEsMC4xLDAuMSwwLjJDMjkuNCwyNC41LDI5LjQsMjQuNiwyOS40LDI0LjZ6IE0zMC42LDIxLjljLTAuMSwwLTAuMSwwLTAuMiwwbC0xLTAuNAoJCWMtMC4yLTAuMS0wLjQtMC4xLTAuNS0wLjFzLTAuMiwwLjEtMC4yLDAuMmMwLDAuMSwwLDAuMiwwLDAuNGMwLjEsMC4xLDAuMSwwLjIsMC4zLDAuM2wxLjEsMC40YzAuMSwwLDAuMSwwLjEsMC4xLDAuMQoJCWMwLDAuMSwwLDAuMSwwLDAuMmwwLDAuMWMwLDAuMS0wLjEsMC4xLTAuMSwwLjFzLTAuMSwwLTAuMiwwbC0xLjctMC43Yy0wLjEsMC0wLjEtMC4xLTAuMS0wLjFzMC0wLjEsMC0wLjJsMC0wLjEKCQljMC0wLjEsMC4xLTAuMSwwLjEtMC4xYzAuMSwwLDAuMSwwLDAuMiwwbDAsMGMwLDAsMCwwLDAsMHMwLDAsMCwwYy0wLjEtMC4zLTAuMi0wLjUtMC4xLTAuOGMwLjEtMC4zLDAuMi0wLjQsMC40LTAuNQoJCWMwLjItMC4xLDAuNCwwLDAuOCwwLjFsMSwwLjRjMC4xLDAsMC4xLDAuMSwwLjEsMC4xczAsMC4xLDAsMC4ybDAsMC4xQzMwLjcsMjEuOSwzMC42LDIxLjksMzAuNiwyMS45eiIvPgoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTE5LDcuMWMwLjMsMCwwLjYsMCwwLjctMC4yYzAuMi0wLjIsMC4zLTAuNSwwLjQtMC45YzAuMS0wLjQsMC0wLjctMC4xLTAuOWMtMC4xLTAuMi0wLjMtMC4zLTAuNy0wLjQKCQljLTAuMSwwLTAuMSwwLTAuMiwwYzAsMCwwLDAtMC4xLDBsLTAuMywyLjNjMCwwLDAsMC4xLDAsMC4xQzE4LjgsNywxOC45LDcsMTksNy4xeiIvPgoJPHBhdGggY2xhc3M9InN0MCIgZD0iTTI5LjIsMTIuM2MwLjItMC4xLDAuMy0wLjIsMC4zLTAuM3MwLTAuMy0wLjEtMC40Yy0wLjEtMC4yLTAuMi0wLjMtMC4zLTAuM2MtMC4xLDAtMC4zLDAtMC40LDAuMQoJCWMtMC40LDAuMi0wLjUsMC41LTAuNCwwLjhDMjguNSwxMi41LDI4LjgsMTIuNiwyOS4yLDEyLjN6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMjcuMSwyNS40Yy0wLjEtMC4xLTAuMi0wLjEtMC40LTAuMWMtMC4xLDAtMC4yLDAuMS0wLjMsMC4yYy0wLjIsMC4yLTAuMSwwLjUsMC4yLDAuOAoJCWMwLjIsMC4yLDAuNCwwLjMsMC41LDAuM2MwLjIsMCwwLjMsMCwwLjQtMC4yYzAuMS0wLjEsMC4xLTAuMiwwLjEtMC40YzAtMC4xLTAuMS0wLjItMC4yLTAuM0wyNy4xLDI1LjR6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMjAuNCwyOC4xYy0wLjEsMC0wLjIsMC4xLTAuMywwLjFjMCwwLDAsMCwwLDAuMWwwLjMsMWMwLDAsMCwwLDAsMGMwLjEsMCwwLjIsMCwwLjMtMC4xCgkJYzAuMi0wLjEsMC40LTAuMiwwLjUtMC4zYzAuMS0wLjEsMC4xLTAuMywwLjEtMC41QzIxLjIsMjguMSwyMC45LDI4LDIwLjQsMjguMXoiLz4KPC9nPgo8L3N2Zz4K'
		);

		add_submenu_page(
			'wp-covid-schema',
			esc_html__( 'About', 'wp-covid-schema' ),
			esc_html__( 'About', 'wp-covid-schema' ),
			'manage_options',
			'wp-covid-schema',
			'wp_covid_schema_getting_started_page'
		);

		add_submenu_page(
			'wp-covid-schema',
			esc_html__( 'COVID-19 Schema Settings', 'wp-covid-schema' ),
			esc_html__( 'Settings', 'wp-covid-schema' ),
			'manage_options',
			'wp-covid-schema-plugin-settings',
			'wp_covid_schema_settings_page'
		);

	}
	add_action( 'admin_menu', 'wp_covid_schema_getting_started_menu' );
}

if (!function_exists('wp_covid_schema_getting_started_page')) {
	function wp_covid_schema_getting_started_page() {		
	?>
		<div class="wrap swwpcs-getting-started">
			<div class="intro-wrap">
				<div class="intro">
					<a href="#"><img class="wp-covid-schema-logo" src="<?php echo esc_url( plugins_url( 'images/logo.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Visit WP COVID Schema', 'wp-covid-schema' ); ?>" /></a>
					<h3><?php printf( esc_html__( 'Schema for', 'wp-covid-schema' ) ); ?> <strong><?php printf( esc_html__( 'COVID-19', 'wp-covid-schema' ) ); ?></strong></h3>
				</div>

				<ul class="swwpcs-menu">
					<li class="current" data-target="#getting-started"><a href="#"><?php esc_html_e( 'About WP COVID Schema', 'wp-covid-schema' ); ?></a></li>
					<li data-target="#support"><a href="#"><?php esc_html_e( 'Support', 'wp-covid-schema' ); ?></a></li>
				</ul>

			</div>

			<div class="panels">
				<div id="panel" class="panel">

					<div id="getting-started" class="content-panel<?php if(!isset($_POST["updated"])) echo ' current'; ?>">
						<div class="swwpcs-block-split clearfix">
							<div class="swwpcs-block-split-left">							
								<div class="swwpcs-titles">
									<h2><?php esc_html_e( 'What is Schema Markup?', 'wp-covid-schema' ); ?></h2>
									<p><?php esc_html_e( 'Schema (schema.org) is referred to a structured data vocabulary defining actions, relationships and entities on the web. This is a code snippet helping search engines to understand the meaning of the subject matters (entities) on the Internet so as to provide the best user experience for the internet users. Search engines including Google is on the mission of building a more semantic web. These markups play a crucial role in effective internet communication.', 'wp-covid-schema' ); ?></p>
									<a href="https://schema.org/" class="sw-btn-submit" target="_blank" rel="noopener"><?php esc_html_e( 'Visit Schema.org', 'wp-covid-schema' ); ?></a>
								</div>
							</div>
							<div class="swwpcs-block-split-right">
								<div class="swwpcs-block-theme">
									<img src="<?php echo esc_url( plugins_url( 'images/img-right.jpg', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'WP COVID-19 Schema Theme', 'wp-covid-schema' ); ?>" />
								</div>
							</div>
						</div>
						<div class="swwpcs-block-full clearfix">							
							<div class="swwpcs-titles">
								<h2><?php esc_html_e( 'What is COVID-19 Schema?', 'wp-covid-schema' ); ?></h2>
								<p><?php esc_html_e( 'On 16th March 2020, Schema.org added coronavirus-related structured data types in version 7.0 due to the massive COVID- 19 outbreak. “CovidTestingFacility” is the significant structured data type introduced in this update. It represents both temporary and established testing facilities opened to handle the Coronavirus pandemic.', 'wp-covid-schema' ); ?></p>
								<a href="https://schema.org/CovidTestingFacility" class="sw-btn-submit" target="_blank" rel="noopener"><?php esc_html_e( 'Visit Details', 'wp-covid-schema' ); ?></a>
							</div>
						</div>
						<div class="swwpcs-block-full clearfix">							
							<div class="swwpcs-titles">
								<h2><?php esc_html_e( 'What are the benefits of adding the COVID-19 Schema now?', 'wp-covid-schema' ); ?></h2>
								<p><?php esc_html_e( 'This schema type has been introduced recently. Search engines are still working on the usage of these snippets for the benefit of the public. Due to the severity of the pandemic it’s for sure that they will give more importance to the website with this snippets.', 'wp-covid-schema' ); ?></p>
							</div>
						</div>
					</div>

					<div id="support" class="content-panel">
						<div class="swwpcs-block-split clearfix">
							<div class="swwpcs-block-split-left">							
								<div class="swwpcs-titles">
									<h2><?php esc_html_e( 'Facing issues with WP COVID-19 Schema?', 'wp-covid-schema' ); ?></h2>
									<p><?php esc_html_e( 'We are actively accepting tickets through WordPress Support forum. Feel free to contact us there!', 'wp-covid-schema' ); ?></p>
								</div>
							</div>
							<div class="swwpcs-block-split-right">
								<div class="swwpcs-block-theme">
									<img src="<?php echo esc_url( plugins_url( 'images/img-support.jpg', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'WP COVID-19 Schema Theme', 'wp-covid-schema' ); ?>" />
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<?php
	}
}

if (!function_exists('wp_covid_schema_settings_page')) {
	function wp_covid_schema_settings_page() {	
		if(isset($_POST["updated"])) {

			swwpcs_handle_form_data();

		}
	?>
		<div class="wrap swwpcs-getting-started">
			<div class="intro-wrap">
				<div class="intro">
					<a href="#"><img class="wp-covid-schema-logo" src="<?php echo esc_url( plugins_url( 'images/logo.png', __FILE__ ) ); ?>" alt="<?php esc_html_e( 'Visit WP COVID Schema', 'wp-covid-schema' ); ?>" /></a>
					<h3><?php printf( esc_html__( 'Configure ', 'wp-covid-schema' ) ); ?> <strong><?php printf( esc_html__( 'COVID-19 Schema Plugin', 'wp-covid-schema' ) ); ?></strong></h3>
				</div>

				<ul class="swwpcs-menu">
					<li class="current" data-target="#swwpcs-testing-facility-schema-settings"><a href="#"><?php esc_html_e( 'Testing Facility Schema Settings', 'wp-covid-schema' ); ?></a></li>
					<li data-target="#swwpcs-school-closure-schema-settings"><a href="#"><?php esc_html_e( 'School Closure Schema Settings', 'wp-covid-schema' ); ?></a></li>
				</ul>

			</div>

			<div class="panels">
				<div id="panel" class="panel">

					<?php if(isset($_POST["updated"])) { ?>
						<div class="wp-covid-schema-alert swwpcs-success">
							<?php esc_html_e( 'Settings updated!', 'wp-covid-schema' ); ?>
						</div>
					<?php } ?>

					<form id="wp-covid-schema-settings" action="" method="POST">
						
						<?php wp_nonce_field('swwpcs_settings', 'swwpcs_settings_nonce'); ?>
						<input type="hidden" name="updated" value="true" />
						
						<div id="swwpcs-testing-facility-schema-settings" class="content-panel current">
							<div class="panel-inner">
								<div class="tab-content">
									<table class="form-table">
										<thead>
											<tr>
												<th>
													<label><?php esc_html_e( 'Enable Schema', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<label class="switch">
														<input id="swwpcs_testing_facility_enable" name="swwpcs_testing_facility_enable" type="checkbox" value="true"<?php if(get_option('swwpcs_testing_facility_enable')) echo ' checked="checked"'; ?>>
														<span class="slider round"></span>
													</label>
												</td>
											</tr>
										<thead>
										<tbody <?php if(!get_option('swwpcs_testing_facility_enable')) { ?>style="display: none;"<?php } ?>>
											<tr>
												<th>
													<label><?php esc_html_e( 'Where you prefer Schema to appear', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<?php $swwpcs_testing_facility_schema_control = get_option('swwpcs_testing_facility_schema_control'); ?>
													<select id="swwpcs_testing_facility_schema_control" name="swwpcs_testing_facility_schema_control">
														<option value="home"<?php if($swwpcs_testing_facility_schema_control == "home") echo ' selected="selected"'; ?>>Homepage</option>
														<option value="all"<?php if($swwpcs_testing_facility_schema_control == "all") echo ' selected="selected"'; ?>>All Pages / Posts</option>
														<option value="page"<?php if($swwpcs_testing_facility_schema_control == "page") echo ' selected="selected"'; ?>>Page</option>
														<option value="post"<?php if($swwpcs_testing_facility_schema_control == "post") echo ' selected="selected"'; ?>>Post</option>
													</select>
												</td>
											</tr>
											<tr class="swwpcs-testing-facility-page-select"<?php if($swwpcs_testing_facility_schema_control == "page") echo ' style="display: table-row;"'; ?>>
												<th>
													<label><?php esc_html_e( 'Select Page', 'wp-covid-schema' ); ?></label>
												</th>
												<td>

													<select id="swwpcs_testing_facility_page_select" name="swwpcs_testing_facility_page_select"<?php if($swwpcs_testing_facility_schema_control == "page") echo ' required="required"'; ?>>
														<option value="">Select a page</option>
														<?php
															$swwpcs_schema_page_post_id = get_option('swwpcs_testing_facility_schema_page_post_id');
															$args = array(
																		'posts_per_page' => -1,
																		'post_type' => 'page'
																	);
															$pages = new WP_Query($args);
															if($pages->have_posts()): while($pages->have_posts()): $pages->the_post();
														?>														
															<option value="<?php the_ID(); ?>"<?php if($swwpcs_schema_page_post_id == get_the_ID()) echo ' selected="selected"'; ?>><?php the_title(); ?></option>
														<?php endwhile; endif; wp_reset_postdata(); ?>

													</select>
												</td>
											</tr>
											<tr class="swwpcs-testing-facility-post-select"<?php if($swwpcs_testing_facility_schema_control == "post") echo ' style="display: table-row;"'; ?>>
												<th>
													<label><?php esc_html_e( 'Select Post', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<select id="swwpcs_testing_facility_post_select" name="swwpcs_testing_facility_post_select"<?php if($swwpcs_testing_facility_schema_control == "post") echo ' required="required"'; ?>>
														<option value="">Select a post</option>
														<?php
															$swwpcs_schema_page_post_id = get_option('swwpcs_testing_facility_schema_page_post_id');
															$args = array(
																		'posts_per_page' => -1,
																		'post_type' => 'post'
																	);
															$posts = new WP_Query($args);
															if($posts->have_posts()): while($posts->have_posts()): $posts->the_post();
														?>														
															<option value="<?php the_ID(); ?>"<?php if($swwpcs_schema_page_post_id == get_the_ID()) echo ' selected="selected"'; ?>><?php the_title(); ?></option>
														<?php endwhile; endif; wp_reset_postdata(); ?>
													</select>
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Announcement Name', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_testing_facility_announcement_name" type="text" name="swwpcs_testing_facility_announcement_name" placeholder="Stanford announce COVID-19 testing facility" value="<?php echo get_option('swwpcs_testing_facility_announcement_name'); ?>" size="40" />
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Description Text', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<textarea id="swwpcs_testing_facility_desc_text" name="swwpcs_testing_facility_desc_text" placeholder="Stanford Health Care’s same-day primary care program is offering drive-through testing, by appointment, for SARS-CoV-2, the coronavirus that causes COVID-19."><?php echo get_option('swwpcs_testing_facility_desc_text'); ?></textarea>
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Announcement Date', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_testing_facility_date_posted" type="text" name="swwpcs_testing_facility_date_posted" placeholder="<?php echo date("Y-m-d"); ?>" value="<?php echo get_option('swwpcs_testing_facility_date_posted'); ?>" readonly size="40" />
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Expires Date (Optional)', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_testing_facility_date_expires" type="text" name="swwpcs_testing_facility_date_expires" placeholder="No Expiry" value="<?php echo get_option('swwpcs_testing_facility_date_expires'); ?>" readonly size="40" />
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Article URL', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_testing_facility_article_url" type="url" name="swwpcs_testing_facility_article_url" placeholder="https://" value="<?php echo get_option('swwpcs_testing_facility_article_url'); ?>" size="40" />
												</td>
											</tr>											
											<tr>
												<th>
													<label><?php esc_html_e( 'Testing Facility Name', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_testing_facility_name" type="text" name="swwpcs_testing_facility_name" placeholder="" value="<?php echo get_option('swwpcs_testing_facility_name') ?: get_bloginfo('name') ; ?>" size="40" />
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Facility Website', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input type="text" placeholder="" value="<?php echo get_bloginfo('url'); ?>" size="40" readonly disabled />
													<p class="swwpcs-small-desc">This cannot be changed.</p>
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Image URL', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_testing_facility_image" type="url" name="swwpcs_testing_facility_image" placeholder="http(s)://" value="<?php echo get_option('swwpcs_testing_facility_image'); ?>" size="40" />
													<p class="swwpcs-small-desc">Please upload the image to <a href="<?php echo get_bloginfo('url'); ?>/wp-admin/media-new.php" target="_blank">Media Library</a> and add the link here.</p>
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Price Range (Optional)', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_testing_facility_price_range" type="text" name="swwpcs_testing_facility_price_range" placeholder="The price range of the business, for example $$$." value="<?php echo get_option('swwpcs_testing_facility_price_range'); ?>" size="40" />
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Address (Optional)', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_testing_facility_address" type="text" name="swwpcs_testing_facility_address" placeholder="Address of the testing facility." value="<?php echo get_option('swwpcs_testing_facility_address'); ?>" size="40" />
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Telephone (Optional)', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_testing_facility_telephone" type="text" name="swwpcs_testing_facility_telephone" placeholder="Telephone Number" value="<?php echo get_option('swwpcs_testing_facility_telephone'); ?>" size="40" />
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<p class="submit">
									<input type="submit" class="sw-btn-submit" value="Save Settings" />	
								</p>
							</div>

							<div class="swwpcs-schema-preview">
								<h3>Schema Preview (Testing Facility)</h3>
								<div id="swwpcs-preview-outer" <?php if(!get_option('swwpcs_testing_facility_enable')) { ?>style="display: none;"<?php } ?>>
									<ul>
										<li><span class="swwpcs-tag">&lt;script</span> type="application/ld+json"&gt;</li>
										<li>{</li>
										<li class="swwpcs-code-indent-1"><span>"@context"</span>: <span>"http://schema.org"</span>,</li>
										<li class="swwpcs-code-indent-1"><span>"@type"</span>: <span>"SpecialAnnouncement"</span>,</li>
										<li class="swwpcs-code-indent-1"><span>"name"</span>: "<span class="swwpcs-announcement-name"><?php echo get_option('swwpcs_testing_facility_announcement_name'); ?></span>",</li>
										<li class="swwpcs-code-indent-1"><span>"text"</span>: "<span class="swwpcs-announcement-text"><?php echo get_option('swwpcs_testing_facility_desc_text'); ?></span>",</li>
										<li class="swwpcs-code-indent-1"><span>"datePosted"</span>: "<span class="swwpcs-announcement-date"><?php echo get_option('swwpcs_testing_facility_date_posted'); ?></span>",</li>

										<?php if(get_option('swwpcs_testing_facility_date_expires')) { ?>
										<li class="swwpcs-code-indent-1"><span>"expires"</span>: "<span class="swwpcs-announcement-date-expires"><?php echo get_option('swwpcs_testing_facility_date_expires'); ?></span>",</li>
										<?php } ?>

										<li class="swwpcs-code-indent-1"><span>"url"</span>: "<span class="swwpcs-article-url"><?php echo get_option('swwpcs_testing_facility_article_url'); ?></span>",</li>
										<li class="swwpcs-code-indent-1"><span>"category"</span>: <span>"https://www.wikidata.org/wiki/Q81068910"</span>,</li>
										<li class="swwpcs-code-indent-1"><span>"about"</span> : {</li>
										<li class="swwpcs-code-indent-2"><span>"@type"</span>: <span>"CovidTestingFacility"</span>,</li>
										<li class="swwpcs-code-indent-2"><span>"name"</span>: "<span class="swwpcs-testing-facility-name"><?php echo get_option('swwpcs_testing_facility_name'); ?></span>",</li>
										<li class="swwpcs-code-indent-2"><span>"url"</span>: "<span class="swwpcs-testing-facility-url"><?php echo get_bloginfo('url'); ?></span>"</li>
										<li class="swwpcs-code-indent-2"><span>"image"</span>: "<span class="swwpcs-testing-facility-image"><?php echo get_option('swwpcs_testing_facility_image'); ?></span>"</li>

										<?php if(get_option('swwpcs_testing_facility_price_range')) { ?>
										<li class="swwpcs-code-indent-2"><span>"priceRange"</span>: "<span class="swwpcs-price-range"><?php echo get_option('swwpcs_testing_facility_price_range'); ?></span>",</li>										
										<?php } ?>

										<?php if(get_option('swwpcs_testing_facility_address')) { ?>
											<li class="swwpcs-code-indent-2"><span>"address"</span>: "<span class="swwpcs-testing-facility-address"><?php echo get_option('swwpcs_testing_facility_address'); ?></span>",</li>										
										<?php } ?>

										<?php if(get_option('swwpcs_testing_facility_telephone')) { ?>
											<li class="swwpcs-code-indent-2"><span>"telephone"</span>: "<span class="swwpcs-testing-facility-telephone"><?php echo get_option('swwpcs_testing_facility_telephone'); ?></span>",</li>										
										<?php } ?>


										
										<li class="swwpcs-code-indent-1">}</li>
										<li>}</li>
										<li><span class="swwpcs-tag">&lt;script&gt;</span></li>
									</ul>
									<a class="sw-btn-submit" href="https://search.google.com/structured-data/testing-tool#url=<?php echo swwpcs_get_test_link(); ?>" target="_blank" rel="noopener">Test Schema on Google</a>
								</div>

								<p class="swwpcs-testing-facility-disabled" <?php if(!get_option('swwpcs_testing_facility_enable')) { ?>style="display: block;"<?php } ?>>Enable the plugin to preview Schema.</p>
							</div>
						
						</div>

						<div id="swwpcs-school-closure-schema-settings" class="content-panel">
							<div class="panel-inner">
								<div class="tab-content">
									<table class="form-table">
										<thead>
											<tr>
												<th>
													<label><?php esc_html_e( 'Enable Schema', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<label class="switch">
														<input id="swwpcs_school_closure_enable" name="swwpcs_school_closure_enable" type="checkbox" value="true"<?php if(get_option('swwpcs_school_closure_enable')) echo ' checked="checked"'; ?>>
														<span class="slider round"></span>
													</label>
												</td>
											</tr>
										<thead>
										<tbody <?php if(!get_option('swwpcs_school_closure_enable')) { ?>style="display: none;"<?php } ?>>
											<tr>
												<th>
													<label><?php esc_html_e( 'Where you prefer Schema to appear', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<?php $swwpcs_school_closure_schema_control = get_option('swwpcs_school_closure_schema_control'); ?>
													<select id="swwpcs_school_closure_schema_control" name="swwpcs_school_closure_schema_control">
														<option value="home"<?php if($swwpcs_school_closure_schema_control == "home") echo ' selected="selected"'; ?>>Homepage</option>
														<option value="all"<?php if($swwpcs_school_closure_schema_control == "all") echo ' selected="selected"'; ?>>All Pages / Posts</option>
														<option value="page"<?php if($swwpcs_school_closure_schema_control == "page") echo ' selected="selected"'; ?>>Page</option>
														<option value="post"<?php if($swwpcs_school_closure_schema_control == "post") echo ' selected="selected"'; ?>>Post</option>
													</select>
												</td>
											</tr>
											<tr class="swwpcs-school-closure-page-select"<?php if($swwpcs_school_closure_schema_control == "page") echo ' style="display: table-row;"'; ?>>
												<th>
													<label><?php esc_html_e( 'Select Page', 'wp-covid-schema' ); ?></label>
												</th>
												<td>

													<select id="swwpcs_school_closure_page_select" name="swwpcs_school_closure_page_select"<?php if($swwpcs_school_closure_schema_control == "page") echo ' required="required"'; ?>>
														<option value="">Select a page</option>
														<?php
															$swwpcs_schema_page_post_id = get_option('swwpcs_school_closure_schema_page_post_id');
															$args = array(
																		'posts_per_page' => -1,
																		'post_type' => 'page'
																	);
															$pages = new WP_Query($args);
															if($pages->have_posts()): while($pages->have_posts()): $pages->the_post();
														?>														
															<option value="<?php the_ID(); ?>"<?php if($swwpcs_schema_page_post_id == get_the_ID()) echo ' selected="selected"'; ?>><?php the_title(); ?></option>
														<?php endwhile; endif; wp_reset_postdata(); ?>

													</select>
												</td>
											</tr>
											<tr class="swwpcs-school-closure-post-select"<?php if($swwpcs_school_closure_schema_control == "post") echo ' style="display: table-row;"'; ?>>
												<th>
													<label><?php esc_html_e( 'Select Post', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<select id="swwpcs_school_closure_post_select" name="swwpcs_school_closure_post_select"<?php if($swwpcs_school_closure_schema_control == "post") echo ' required="required"'; ?>>
														<option value="">Select a post</option>
														<?php
															$swwpcs_schema_page_post_id = get_option('swwpcs_school_closure_schema_page_post_id');
															$args = array(
																		'posts_per_page' => -1,
																		'post_type' => 'post'
																	);
															$posts = new WP_Query($args);
															if($posts->have_posts()): while($posts->have_posts()): $posts->the_post();
														?>														
															<option value="<?php the_ID(); ?>"<?php if($swwpcs_schema_page_post_id == get_the_ID()) echo ' selected="selected"'; ?>><?php the_title(); ?></option>
														<?php endwhile; endif; wp_reset_postdata(); ?>
													</select>
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Announcement Name', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_school_closure_announcement_name" type="text" name="swwpcs_school_closure_announcement_name" placeholder="School Closure information for Eastergate School" value="<?php echo get_option('swwpcs_school_closure_announcement_name'); ?>" size="40" />
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Text', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<textarea id="swwpcs_school_closure_desc_text" name="swwpcs_school_closure_desc_text" placeholder="School closure information has been published."><?php echo get_option('swwpcs_school_closure_desc_text'); ?></textarea>
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Date', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_school_closure_date_posted" type="text" name="swwpcs_school_closure_date_posted" placeholder="<?php echo date("Y-m-d"); ?>" value="<?php echo get_option('swwpcs_school_closure_date_posted'); ?>" readonly size="40" />
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Expires', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_school_closure_expires" type="text" name="swwpcs_school_closure_expires" placeholder="<?php echo date("Y-m-d"); ?>" value="<?php echo get_option('swwpcs_school_closure_expires'); ?>" readonly size="40" />
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Info Article Link', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_school_closure_article_link" type="text" name="swwpcs_school_closure_article_link" placeholder="url" value="<?php echo get_option('swwpcs_school_closure_article_link'); ?>" size="40" />
												</td>
											</tr>
											<tr>
												<th colspan="2">
													<h3><?php esc_html_e( 'Feed Settings', 'wp-covid-schema' ); ?></h3>
												</th>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Enable Web Feed', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<label class="switch">
														<input id="swwpcs_school_closure_web_feed_enable" name="swwpcs_school_closure_web_feed_enable" type="checkbox" value="true"<?php if(get_option('swwpcs_school_closure_web_feed_enable')) echo ' checked="checked"'; ?>>
														<span class="slider round"></span>
													</label>
												</td>
											</tr>
											<tr class="web-feed-details"<?php if(get_option('swwpcs_school_closure_web_feed_enable')) { echo ' style="display: table-row;"'; } ?>>
												<th>
													<label><?php esc_html_e( 'Feed URL', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_school_closure_feed_url" type="text" name="swwpcs_school_closure_feed_url" placeholder="http://example.org/schools/school/eastergate-cofe-primary-school/closures" value="<?php echo get_option('swwpcs_school_closure_feed_url'); ?>" size="40" />
												</td>
											</tr>
											<tr class="web-feed-details"<?php if(get_option('swwpcs_school_closure_web_feed_enable')) { echo ' style="display: table-row;"'; } ?>>
												<th>
													<label><?php esc_html_e( 'Encoding Format', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<select id="swwpcs_school_closure_encoding_format" name="swwpcs_school_closure_encoding_format">
														<option value="application/rss+atom"<?php if($swwpcs_school_closure_encoding_format == "home") echo ' selected="selected"'; ?>>application/rss+atom</option>
													</select>
												</td>
											</tr>
											<tr>
												<th colspan="2">
													<h3><?php esc_html_e( 'Location Settings', 'wp-covid-schema' ); ?></h3>
												</th>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Location Name', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_school_closure_location_name" type="text" name="swwpcs_school_closure_location_name" placeholder="Eastergate School" value="<?php echo get_option('swwpcs_school_closure_location_name'); ?>" size="40" />
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Website', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input type="text" placeholder="" value="<?php echo get_bloginfo('url'); ?>" size="40" readonly disabled />
													<p class="swwpcs-small-desc">This cannot be changed.</p>
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Location', 'wp-covid-schema' ); ?></label>
												</th>
												<td>
													<input id="swwpcs_school_closure_location" type="text" name="swwpcs_school_closure_location" placeholder="..." value="<?php echo get_option('swwpcs_school_closure_location'); ?>" size="40" />
												</td>
											</tr>
											
										</tbody>
									</table>
								</div>
								<p class="submit">
									<input type="submit" class="sw-btn-submit" value="Save Settings" />	
								</p>						
							</div>
							<div class="swwpcs-schema-preview">
								<h3>Schema Preview (School Closure)</h3>
								<div id="swwpcs-school-closure-preview-outer" <?php if(get_option('swwpcs_school_closure_enable')) { ?>style="display: block;"<?php } ?>>
									<ul>
										<li><span class="swwpcs-tag">&lt;script</span> type="application/ld+json"&gt;</li>
										<li>{</li>
										<li class="swwpcs-code-indent-1"><span>"@context"</span>: <span>"http://schema.org"</span>,</li>
										<li class="swwpcs-code-indent-1"><span>"@type"</span>: <span>"SpecialAnnouncement"</span>,</li>
										<li class="swwpcs-code-indent-1"><span>"name"</span>: "<span class="swwpcs_school_closure_announcement_name"><?php echo get_option('swwpcs_school_closure_announcement_name'); ?></span>",</li>
										<li class="swwpcs-code-indent-1"><span>"text"</span>: "<span class="swwpcs_school_closure_desc_text"><?php echo get_option('swwpcs_school_closure_desc_text'); ?></span>",</li>
										<li class="swwpcs-code-indent-1"><span>"datePosted"</span>: "<span class="swwpcs_school_closure_date_posted"><?php echo get_option('swwpcs_school_closure_date_posted'); ?></span>",</li>
										<li class="swwpcs-code-indent-1"><span>"expires"</span>: "<span class="swwpcs_school_closure_expires"><?php echo get_option('swwpcs_school_closure_expires'); ?></span>",</li>
										<li class="swwpcs-code-indent-1"><span>"category"</span>: "<span class="">https://www.wikidata.org/wiki/Q81068910</span>",</li>
										<li class="swwpcs-code-indent-1"><span>"schoolClosuresInfo"</span>: "<span class="swwpcs_school_closure_article_link"><?php echo get_option('swwpcs_school_closure_article_link'); ?></span>",</li>
										<?php if(get_option('swwpcs_school_closure_web_feed_enable')) { ?>
										<li class="swwpcs-code-indent-1 webfeed"><span>"webFeed"</span> : {</li>
										<li class="swwpcs-code-indent-2 webfeed"><span>"@type"</span>: <span>"DataFeed"</span>,</li>
										<li class="swwpcs-code-indent-2 webfeed"><span>"@url"</span>: "<span class="swwpcs_school_closure_feed_url"><?php echo get_option('swwpcs_school_closure_feed_url'); ?></span>",</li>
										<li class="swwpcs-code-indent-2 webfeed"><span>"encodingFormat"</span>: "<span class="swwpcs_school_closure_encoding_format"><?php echo get_option('swwpcs_school_closure_encoding_format'); ?></span>"</li>
										<li class="swwpcs-code-indent-1 webfeed">},</li>
										<?php } ?>
										<li class="swwpcs-code-indent-1"><span>"announcementLocation"</span> : {</li>
										<li class="swwpcs-code-indent-2"><span>"@type"</span>: <span>"School"</span>,</li>
										<li class="swwpcs-code-indent-2"><span>"name"</span>: "<span class="swwpcs_school_closure_location_name"><?php echo get_option('swwpcs_school_closure_location_name'); ?></span>",</li>
										<li class="swwpcs-code-indent-2"><span>"url"</span>: "<span class="swwpcs_school_closure_location_url"><?php echo get_bloginfo('url'); ?></span>"</li>
										<li class="swwpcs-code-indent-2"><span>"location"</span>: "<span class="swwpcs_school_closure_location"><?php echo get_option('swwpcs_school_closure_location'); ?></span>"</li>
										<li class="swwpcs-code-indent-1">}</li>
										<li>}</li>
										<li><span class="swwpcs-tag">&lt;script&gt;</span></li>
									</ul>
									<a class="sw-btn-submit" href="https://search.google.com/structured-data/testing-tool#url=<?php echo swwpcs_get_test_link(); ?>" target="_blank" rel="noopener">Test Schema on Google</a>
								</div>

								<p class="swwpcs-school-closure-disabled" <?php if(!get_option('swwpcs_school_closure_enable')) { ?>style="display: block;"<?php } ?>>Enable the plugin to preview Schema.</p>
							</div>

						</div>
					</form>				
				</div>
			</div>
		</div>
		<?php
	}
}



if (!function_exists('swwpcs_handle_form_data')) {
	function swwpcs_handle_form_data() {

		if(!isset( $_POST['swwpcs_settings_nonce'] ) || ! wp_verify_nonce( $_POST['swwpcs_settings_nonce'], 'swwpcs_settings' )) {
			print 'Sorry, your nonce did not verify.';
			exit;
		}
		
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

				
		// Testing Facility Schema
		$swwpcs_testing_facility_enable = false;
		if(isset($_POST['swwpcs_testing_facility_enable'])) $swwpcs_testing_facility_enable = true;
		swwpcs_update_settings( 'swwpcs_testing_facility_enable', $swwpcs_testing_facility_enable);

		$swwpcs_testing_facility_schema_control = sanitize_text_field($_POST['swwpcs_testing_facility_schema_control']);
		swwpcs_update_settings( 'swwpcs_testing_facility_schema_control', $swwpcs_testing_facility_schema_control);

		if($swwpcs_testing_facility_schema_control == "post") {
			swwpcs_update_settings( 'swwpcs_testing_facility_schema_page_post_id', sanitize_text_field($_POST['swwpcs_testing_facility_post_select']));
		} else if($swwpcs_testing_facility_schema_control == "page") {
			swwpcs_update_settings( 'swwpcs_testing_facility_schema_page_post_id', sanitize_text_field($_POST['swwpcs_testing_facility_page_select']));
		} else {
			// Deleting option
			swwpcs_update_settings( 'swwpcs_testing_facility_schema_page_post_id', "");
		}

		swwpcs_update_settings( 'swwpcs_testing_facility_announcement_name', sanitize_text_field($_POST['swwpcs_testing_facility_announcement_name']));
		swwpcs_update_settings( 'swwpcs_testing_facility_desc_text', sanitize_textarea_field($_POST['swwpcs_testing_facility_desc_text']));

		$swwpcs_testing_facility_date_posted = sanitize_text_field($_POST['swwpcs_testing_facility_date_posted']);
		if(validate_date_format($swwpcs_testing_facility_date_posted)) { swwpcs_update_settings( 'swwpcs_testing_facility_date_posted', $swwpcs_testing_facility_date_posted); }

		$swwpcs_testing_facility_date_expires = sanitize_text_field($_POST['swwpcs_testing_facility_date_expires']);
		if(validate_date_format($swwpcs_testing_facility_date_expires)) { swwpcs_update_settings( 'swwpcs_testing_facility_date_expires', $swwpcs_testing_facility_date_expires); }

		swwpcs_update_settings( 'swwpcs_testing_facility_article_url', esc_url_raw($_POST['swwpcs_testing_facility_article_url']));
		swwpcs_update_settings( 'swwpcs_testing_facility_price_range', sanitize_text_field($_POST['swwpcs_testing_facility_price_range']));
		swwpcs_update_settings( 'swwpcs_testing_facility_address', sanitize_text_field($_POST['swwpcs_testing_facility_address']));
		swwpcs_update_settings( 'swwpcs_testing_facility_telephone', sanitize_text_field($_POST['swwpcs_testing_facility_telephone']));

		swwpcs_update_settings( 'swwpcs_testing_facility_name', sanitize_text_field($_POST['swwpcs_testing_facility_name']));
		swwpcs_update_settings( 'swwpcs_testing_facility_image', sanitize_text_field($_POST['swwpcs_testing_facility_image']));

		
		// School Closure Schema
		$swwpcs_school_closure_enable = false;
		if(isset($_POST['swwpcs_school_closure_enable'])) $swwpcs_school_closure_enable = true;
		swwpcs_update_settings( 'swwpcs_school_closure_enable', $swwpcs_school_closure_enable);
		$swwpcs_school_closure_schema_control = sanitize_text_field($_POST['swwpcs_school_closure_schema_control']);
		swwpcs_update_settings( 'swwpcs_school_closure_schema_control', $swwpcs_school_closure_schema_control);

		if($swwpcs_school_closure_schema_control == "post") {
			swwpcs_update_settings( 'swwpcs_school_closure_schema_page_post_id', sanitize_text_field($_POST['swwpcs_school_closure_post_select']));
		} else if($swwpcs_school_closure_schema_control == "page") {
			swwpcs_update_settings( 'swwpcs_school_closure_schema_page_post_id', sanitize_text_field($_POST['swwpcs_school_closure_page_select']));
		} else {
			// Deleting option
			swwpcs_update_settings( 'swwpcs_school_closure_schema_page_post_id', "");
		}

		swwpcs_update_settings( 'swwpcs_school_closure_announcement_name', sanitize_text_field($_POST['swwpcs_school_closure_announcement_name']));
		swwpcs_update_settings( 'swwpcs_school_closure_desc_text', sanitize_text_field($_POST['swwpcs_school_closure_desc_text']));
		swwpcs_update_settings( 'swwpcs_school_closure_date_posted', sanitize_text_field($_POST['swwpcs_school_closure_date_posted']));
		swwpcs_update_settings( 'swwpcs_school_closure_expires', sanitize_text_field($_POST['swwpcs_school_closure_expires']));
		swwpcs_update_settings( 'swwpcs_school_closure_article_link', sanitize_text_field($_POST['swwpcs_school_closure_article_link']));

		$swwpcs_school_closure_web_feed_enable = false;
		if(isset($_POST['swwpcs_school_closure_web_feed_enable'])) $swwpcs_school_closure_web_feed_enable = true;
		swwpcs_update_settings( 'swwpcs_school_closure_web_feed_enable', $swwpcs_school_closure_web_feed_enable);

		swwpcs_update_settings( 'swwpcs_school_closure_feed_url', sanitize_text_field($_POST['swwpcs_school_closure_feed_url']));
		swwpcs_update_settings( 'swwpcs_school_closure_encoding_format', sanitize_text_field($_POST['swwpcs_school_closure_encoding_format']));
		swwpcs_update_settings( 'swwpcs_school_closure_location_name', sanitize_text_field($_POST['swwpcs_school_closure_location_name']));
		swwpcs_update_settings( 'swwpcs_school_closure_location_url', sanitize_text_field($_POST['swwpcs_school_closure_location_url']));
		swwpcs_update_settings( 'swwpcs_school_closure_location', sanitize_text_field($_POST['swwpcs_school_closure_location']));

		return;

	}
}

if (!function_exists('validate_date_format')) {
	function validate_date_format($date) {
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
			return true;
		} else {
			return false;
		}
	}
}

if (!function_exists('swwpcs_update_settings')) {
	function swwpcs_update_settings($param, $value) {
		if ( ! empty( $value ) ) {
			update_option( $param, wp_unslash( $value ), false );
		} else {
			delete_option( $param );
		}
	}
}

if (!function_exists('swwpcs_admin_style')) {
	
	function swwpcs_admin_style() {
		echo '<style>
			#adminmenu .toplevel_page_wp_covid_schema div.wp-menu-image.svg {
				background-size: 24px auto;
			}
		</style>';
	}
	add_action('admin_head', 'swwpcs_admin_style');

}