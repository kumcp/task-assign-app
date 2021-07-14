<?php 

	/*
	* showErrors()
	* Hiển thị lỗi
	* @param: $errors, $name
	* return: error string
	*/

	function showErrors($errors, $name) {
		if($errors->has($name)) {
			$html  = '<span class="text-danger">';
			$html .= $errors->first($name);
			$html .= '</span>';
	    	return $html;
		}
	}

?>