<?php

class uwfWidgetControls {
	
	static function render($widget, $args, $instance, $echo = true) {
	
		$output = '<ul class="widget-controls">';
		foreach ($args as $arg => $arg_attr) {
			$classes = array(
				'widget-control',	
			);
			if ( isset($arg_attr['advanced']) && $arg_attr['advanced'] ? ' class="widget-control-advanced"' : '' ) { $classes[] = 'widget-control-advanced'; }
			if ( isset($arg_attr['classes']) && $arg_attr['classes'] ) { $classes[] = $arg_attr['classes']; }
			$output .= '<li class="' . implode(' ', $classes) . '">';
			$id = esc_attr($widget->get_field_id( $arg ));
			$name = esc_attr($widget->get_field_name( $arg ));
			$type = isset($arg_attr['type']) ? $arg_attr['type'] : 'text';
			$label = isset($arg_attr['label']) ? '<label for="' . $id . '">' . $arg_attr['label'] . '</label>' : '';
			$value = isset( $instance[$arg] ) ? $instance[$arg] : (isset($arg_attr['default']) ? $arg_attr['default'] : '');
			switch ($arg_attr['type']) {
				case 'text':
					$output .= $label . ' <input class="widefat" id="'.$id.'" name="'.$name.'" type="text" value="'.esc_attr($value).'">';
				break;
				
				case 'select':
					$output .= $label . ' <select class="widefat" id="'.$id.'" name="'.$name.'">';
					if (!$value) { $output .= '<option>-</option>'; }
					foreach ($arg_attr['options'] as $option_value => $option_name) {
						$output .= '<option value="'.esc_attr($option_value).'"'.selected( $value, $option_value, false ).'>'.esc_html($option_name).'</option>';
					}
					$output .= '</select>';
				break;
				
				case 'number':
					$value = (int) $value;
					$output .= $label . ' <input id="'.$id.'" name="'.$name.'" type="number" step="1" min="0" class="tiny-text" value="'.esc_attr($value).'">';
				break;
				
				case 'checkbox':
					$checked = $value ? ' checked="checked"' : '';
					$output .= '<input type="checkbox" id="'.$id.'" name="'.$name.'" value="1"'.$checked.'> ' . $label;
				break;
				
				case 'checkboxes':
					$output .= $label . '<br />';
					$values = unserialize($value);
					if (!is_array($values)) { $values = array(); }
					$options = isset($arg_attr['options']) ? $arg_attr['options'] : array();
					if (!is_array($options)) { $options = array(); }
					foreach ($options as $option) {
						$checked = in_array( $option, $values ) ? ' checked="checked"' : '';
						$option_id = $id . '-' . sanitize_key( $option );
						$option_escaped = esc_attr($option);
						$option_label = '<label for="' . $option_id . '" class="checkboxes-option">' . esc_html($option) . '</label>';
						$output .= '<input type="checkbox" id="'.$option_id.'" name="'.$name.'[]" value="'.$option_escaped.'"'.$checked.'> ' . $option_label . '<br />';
					}
				break;
				
				case 'textarea':
					$output .= $label . '<textarea class="widefat" id="'.$id.'" name="'.$name.'">'.esc_textarea($value).'</textarea>';
				break;
			}
			$output .= isset($arg_attr['description']) ? '<div class="widget-control-description">' . wpautop($arg_attr['description']) . '</div>' : '';
			$output .= '</li>';
		}
		$output .= '</ul>';
		if ($echo) { 
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Output contains widget form HTML built from safe inputs
			echo $output;
		}
		return $output;
	}
}