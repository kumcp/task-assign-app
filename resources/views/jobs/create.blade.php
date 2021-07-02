@extends('layouts.job-crud', [
	'routeName' => 'jobs.store',
	'method' => 'POST', 
	'staff' => $staff,
	'jobs' => $jobs,
	'projects' => $projects,
	'jobTypes' => $jobTypes,
	'priorities' => $priorities,
	'processMethods' => $processMethods	
])

@section('assign-button-group')
	{{-- TODO: Thêm 2 link xem chi tiết + bô sung --}}
	
@endsection

@section('button-group')

	@include('components.button-group', [
		'buttons' => [
			['iconClass' => 'fas fa-save', 'value' => 'Lưu', 'action' => 'save'], 
			['iconClass' => 'fas fa-copy', 'value' => 'Lưu-sao', 'action' => 'save_copy'], 
			['iconClass' => 'fas fa-edit', 'value' => 'Sửa', 'action' => 'edit'], 
			['iconClass' => 'fas fa-trash', 'value' => 'Xóa', 'action' => 'delete'], 
			['iconClass' => 'fas fa-search', 'value' => 'Tìm kiếm', 'action' => 'search'], 
		] 
	])
	
@endsection
