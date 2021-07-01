@extends('layouts.job-crud')

@section('assign-button-group')
	@include('components.buttons', [
		'parentClass' => 'btn-group',
		'buttons' => [
			['iconClass' => 'fas fa-info-circle', 'value' => 'Xem chi tiết'], 
		]
	])
@endsection

@section('button-group')

	@include('components.buttons', [
		'buttons' => [
			['iconClass' => 'fas fa-check', 'value' => 'Nhận việc'], 
			['iconClass' => 'fas fa-times', 'value' => 'Từ chối'], 
			['iconClass' => 'fas fa-comment', 'value' => 'Trao đổi'], 
		] 
	])
	
@endsection