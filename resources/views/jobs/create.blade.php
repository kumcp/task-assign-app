{{-- @extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
        
            <div class="col-md-9">
                <form>
					<div class="form-group-row mb-3">
						@include('components.select', [
							'name' => 'assigner',
							'label' => 'Người giao việc',
							'options' => ['ABAC', 'ASCS'],	
							])
					</div>
					<div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'project_code',
							'label' => 'Mã dự án'	
						])
					</div>

              		<div class="form-group-row mb-3">
						@include('components.select', [
							'name' => 'job_type', 
							'label' => 'Loại công việc', 
							'options' => ['Dự án', 'Training']
						])
                        
                    </div>
					<div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'period',
							'label' => 'Kỳ'
						])
						@include('components.select', [
							'name' => 'period_unit', 
							'label' => 'Đơn vị',
							'options' => ['Ngày', 'Tuần', 'Tháng']
						])
					</div>
                    <div class="form-group-row mb-3">
						@include('components.select', [
							'name' => 'parent_job', 
							'label' => 'Việc cha', 
							'options' => ['ABC', 'XYZ']
						])
                    </div>
                    <div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'job_code',
							'label' => 'Mã CV'
						])
						@include('components.select', [
							'name' => 'priorities', 
							'label' => 'Độ ưu tiên', 
							'options' => ['ABC', 'XYZ', 'DEF'] 
						])

                    </div>
                    <div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'job_name', 
							'label' => 'Tên công việc'
						])
                    </div>
                    <div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'lsx_amount', 
							'label' => 'Khối lượng LSX'
						])
                        <label>(Man day)</label>
                    </div>
                    <div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'assign_amount', 
							'label' => 'Khối lượng giao'
						])
                        <label>(Man day)</label>
                    </div>
                    <div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'deadline', 
							'label' => 'Hạn xử lý',
						])
                    </div>
                    <div class="form-group-row mb-3">
                        @include('components.text-area', [
							'name' => 'description',
							'label' => 'Mô tả CV',
						])
                    </div>
                    <div class="form-group-row mb-3">
                        @include('components.input-file', [
							'name' => 'file',
							'label' => 'Tệp nội dung',
						])
                    </div>
              
                    
                    <div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'chu-tri', 
							'label' => 'Chủ trì'
						])

                    </div>
                    <div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'phoi-hop', 
							'label' => 'Phối hợp'
						])
						
                    </div>
                    <div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'nhan-xet', 
							'label' => 'Theo dõi, nhận xét'
						])
						
					</div>
					<div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'status', 
							'label' => 'Trạng thái'
						])
					</div>
                    
                    
					<div class="btn-group offset-3" role="group">
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-save"></i>
                            <span>Lưu</span>
                        </button>
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-copy"></i>
                            <span>Lưu-sao</span>
                        </button>
						<button type="submit" class="btn btn-light">
                            <i class="fas fa-edit"></i>
                            <span>Sửa</span>
                        </button>
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-trash"></i>
                            <span>Xóa</span>
                        </button>
						<button type="submit" class="btn btn-light">
                            <i class="fas fa-search"></i>
                            <span>Tìm kiếm</span>
                        </button>
                    </div>
                  </form>
            </div>
            <div class="col">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Tên công việc</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Jacob</td>
                      </tr>
                      <tr>
                        <td>Jacob</td>
                      </tr>
                      <tr>
                        <td>Jacob</td>
                      </tr>
                      <tr>
                        <td>Jacob</td>
                      </tr>
                      <tr>
                        <td>Jacob</td>
                      </tr>
                      <tr>
                        <td>Jacob</td>
                      </tr>
                      <tr>
                        <td>Jacob</td>
                      </tr>
                      <tr>
                        <td>Jacob</td>
                      </tr>
                      <tr>
                        <td>Jacob</td>
                      </tr>
                      <tr>
                        <td>Jacob</td>
                      </tr>
                    </tbody>
                  </table>
            </div>

        </div>
        
                
    </div>
    
@endsection --}}


@extends('layouts.job-crud', [
	'routeName' => 'jobs.store',
	'method' => 'POST', 
	
])

@section('assign-button-group')
	{{-- @include('components.buttons', [
		'parentClass' => 'btn-group',
		'buttons' => [
			['iconClass' => 'fas fa-info-circle', 'value' => 'Xem chi tiết'], 
			['iconClass' => 'fas fa-plus', 'value' => 'Bổ sung'], 
		]
	]) --}}
	<div class="btn-group offset-4" role="group">
		<a href="#" class="btn btn-link text-decoration-none">
			<i class="fas fa-info-circle"></i>
			<span>Xem chi tiết</span>
		</a>
		<a href="#" class="btn btn-link text-decoration-none">
			<i class="fas fa-plus"></i>
			<span>Bổ sung</span>
		</a>
	</div>
@endsection

@section('button-group')

	@include('components.buttons', [
		'buttons' => [
			['iconClass' => 'fas fa-save', 'value' => 'Lưu', 'action' => 'save'], 
			['iconClass' => 'fas fa-copy', 'value' => 'Lưu-sao', 'action' => 'save_copy'], 
			['iconClass' => 'fas fa-edit', 'value' => 'Sửa', 'action' => 'edit'], 
			['iconClass' => 'fas fa-trash', 'value' => 'Xóa', 'action' => 'delete'], 
			['iconClass' => 'fas fa-search', 'value' => 'Tìm kiếm', 'action' => 'search'], 
		] 
	])
	
@endsection

<script>
	
</script>