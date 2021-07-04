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
// Danh mục đệ quy
/**
*$parent_id_child : parent_id của bản ghi đang sửa
*/
function getCategory($categories, $parent,$char,$parent_id_child) {
	foreach ($categories as $key => $value) {
		if($value['parent_id'] == $parent) {
			if($value['id'] == $parent_id_child) {
				echo '<option selected value="'.$value['id'].'">'.$char.$value['name'].'</option>';
			}else{
				echo '<option value="'.$value['id'].'">'.$char.$value['name'].'</option>';
			}
			$new_parent = $value['id'];
			getCategory($categories,$new_parent,$char.'|--',$parent_id_child);
		}
	}
}

function showCategory($categories, $parent,$char) {
	foreach ($categories as $key => $value) {
		if($value['parent_id'] == $parent) {
			$html  = '<div>';
			$html .= '<div class="item-menu">';
			$html .= '<span>'.$char.$value['name'].'</span>';
			$html .= '<div class="category-fix">';
			$html .= '<a class="btn-category btn-primary" href="'.route('category.edit',['id'=>$value['id']]).'"><i class="fa fa-edit"></i></a>';
			$html .= '<a class="btn-category btn-danger" href="'.route('category.destroy',['id'=>$value['id']]).'"><i class="fas fa-times"></i></i></a></div></div>';
			echo $html;
			$new_parent = $value['id'];
			showCategory($categories,$new_parent,$char.'|--');
		}
	}
}

?>