@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <form action="#" class="w-100">
                <div class="form-group-row mb-3">
                    @include('components.select', [
                        'name' => 'job_type',
						'label' => 'Loại công việc',
						'options' => ['Tất cả', 'Dự án', 'Training']
                    ])
                    @include('components.select', [
                        'name' => 'project',
						'label' => 'Dự án',
						'options' => ['Tất cả', 'CodeStar']
                    ])
                    {{-- <label class="mr-5" for="job_type">Loại công việc</label>
                    <select name="job_type" id="job_type">
                        <option value="Tất cả">Tất cả</option>
                        <option value="Dự án">Dự án</option>
                    </select> --}}

                    {{-- <label class="mx-5" for="project">Dự án</label>
                    <select name="project" id="project">
                        <option value="Tất cả">Tất cả</option>
                        <option value="ABC">ABC</option>
                    </select> --}}
                    
                </div>

                <div class="form-group-row mb-3">
                    @include('components.select', [
                        'name' => 'status',
                        'label'=> 'Trạng thái',
                        'options' => ['Tất cả', 'Chưa nhận', 'Đã giao', 'Chưa xử lý']
                    ])

                    @include('components.select', [
                        'name' => 'assessment',
                        'label'=> 'Đánh giá',
                        'options' => ['Tốt', 'Trung bình', 'Kém']
                    ])


                    {{-- <label for="status" class="col-form-label mr-5">Trạng thái</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Tất cả">Tất cả</option>
                        <option value="Chưa nhận">Chưa nhận</option>
                        <option value="Đang xử lý">Đang xử lý</option>
                    </select> --}}
                    
            
                    {{-- <label class="mx-5" for="assessment">Đánh giá</label>
                    <select name="assessment" id="assessment">
                        <option value="Tốt">Tốt</option>
                        <option value="Trung bình">Trung bình</option>
                    </select> --}}
                </div>

                <div class="form-group-row mb-3">
                    @include('components.select', [
                        'name' => 'assigner',
                        'label' => 'Người giao',
                        'options' => ['Tất cả', 'AVC', 'XYZ']
                    ])
                    @include('components.input-text', [
                        'name' => 'job_name',
                        'label' => 'Tên công việc'
                    ])
                    {{-- <label class="mr-5" for="assigner">Người giao</label>
                    <select name="assigner" id="assigner">
                        <option value="Tất cả">Tất cả</option>
                        <option value="ABC">ABC</option>
                    </select> --}}
                    
                    {{-- <label class="mx-5" for="job_name">Tên công việc</label>
                    <input type="text" name="job_name" id="job_name"> --}}
                   
                </div>
               
                <div class="form-group-row">
					@include('components.input-date', [
						'type' => 'date',
						'name' => 'from_date',
						'label' => 'Từ ngày'
					])
					@include('components.input-date', [
						'type' => 'date',
						'name' => 'to_date',
						'label' => 'Đến ngày'
					])
                    {{-- <label class="col-sm-2 col-form-label" for="from_date">Từ ngày</label>
                    <input type="date" name="from_date" id="from_date">
                    <label class="col-sm-2 col-form-label" for="to_date">Đến ngày</label>
                    <input type="date" name="to_date" id="to_date"> --}}
                </div>

            </form>
        </div>
        <div class="row">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
				  <a class="nav-link active" id="direct-tab" data-toggle="tab" href="#direct" role="tab" aria-controls="direct" aria-selected="true">Công việc trực tiếp xử lý</a>
				</li>
				<li class="nav-item" role="presentation">
				  <a class="nav-link" id="related-tab" data-toggle="tab" href="#related" role="tab" aria-controls="related" aria-selected="false">Công việc liên quan</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="direct" role="tabpanel" aria-labelledby="direct-tab">
					<table class="table">
						<thead>
						  <tr>
							<th scope="col">Mã dự án</th>
							<th scope="col">Tên công việc</th>
							<th scope="col">Người giao</th>
							<th scope="col">Hình thức xử lý</th>
							<th scope="col">Hạn xử lý</th>
							<th scope="col">KL giao</th>
							<th scope="col">KL timesheet</th>
							<th scope="col">% hoàn thành</th>
							<th scope="col">Số ngày còn lại</th>
							<th scope="col"><input type="checkbox" name="option" id="option"></th>
						  </tr>
						</thead>
						<tbody>
						  <tr>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
							<td>@mdo</td>
						  </tr>
						  <tr>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
							<td>@mdo</td>
						  </tr>
						  <tr>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
							<td>@mdo</td>
						  </tr>
						</tbody>
					</table>
				</div>
				<div class="tab-pane fade" id="related" role="tabpanel" aria-labelledby="related-tab">
					<table class="table">
						<thead>
						  <tr>
							<th scope="col">Mã dự án</th>
							<th scope="col">Tên công việc</th>
							<th scope="col">Người giao</th>
							<th scope="col">Hình thức xử lý</th>
							<th scope="col">Hạn xử lý</th>
							<th scope="col">KL giao</th>
							<th scope="col">KL timesheet</th>
							<th scope="col">% hoàn thành</th>
							<th scope="col">Số ngày còn lại</th>
							<th scope="col"><input type="checkbox" name="option" id="option"></th>
						  </tr>
						</thead>
						<tbody>
						  <tr>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
							<td>Mark</td>
							<td>Otto</td>
							<td>@mdo</td>
							<td>@mdo</td>
						  </tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
    </div>   
@endsection