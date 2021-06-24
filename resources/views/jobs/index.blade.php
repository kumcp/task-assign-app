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
						'options' => ['Tất cả', 'ABC', 'CodeStar']
					])
					
					{{-- <label for="job_type" class="col-sm-2 col-form-label">Loại công việc</label>
					<div class="col-sm-4 d-inline">
						<select name="job_type" id="job_type">
							<option value="all">Tất cả</option>
							<option value="temp">Temp</option>
						</select>
					</div> --}}
                    {{-- <label for="project" class="col-sm-2 col-form-label">Dự án</label>
					<div class="col-sm-4 d-inline">
						<select name="project" id="project" class="form-control-sm">
							<option value="all">Tất cả</option>
							<option value="temp">Temp</option>
						</select>
					</div> --}}

                </div>
                <div class="form-group-row mb-3">
                    @include('components.select', [
						'name' => 'assigner',
						'label' => 'Người giao',
						'options' => ['Tất cả', 'Hoang Huy Quan']
					])
					{{-- <label for="assigner" class="col-sm-2 col-form-label">Người giao</label>
                    <div class="col-sm-4 d-inline">
						<select name="assigner" id="assigner" >
							<option value="all">Tất cả</option>
							<option value="temp">Temp</option>
						</select>
					</div> --}}
					@include('components.input-text', [
						'name' => 'job_name',
						'label' => 'Tên công việc'
					])
					
                	{{-- <label for="name" class="col-sm-2 col-form-label">Tên công việc</label>
					<div class="col-sm-4 d-inline">
						<input type="text" name="name" id="name">
					</div> --}}
                    
                </div>
                <div class="form-group-row">
					@include('components.input-date', [
						'name' => 'from_date',
						'label' => 'Từ ngày',
						'type' => 'date',
					])
					@include('components.input-date', [
						'name' => 'to_date',
						'label' => 'Đến ngày',
						'type' => 'date',
					])
					{{-- <label for="from_date" class="col-sm-2 col-form-label">Từ ngày</label>
					<div class="col-sm-4 d-inline">
						<input type="time" name="from_date" id="from_date">
					</div> --}}
					{{-- <label for="to_date" class="col-sm-2 col-form-label">Đến ngày</label>
                    <div class="col-sm-4 d-inline">
						<input type="time" name="to_date" id="to_date">
					</div> --}}
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
        {{-- <div class="row">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
				  <button class="nav-link active" id="direct-tab" data-bs-toggle="tab" data-bs-target="#direct" type="button" role="tab" aria-controls="direct" aria-selected="true">Công việc trực tiếp xử lý</button>
				</li>
				<li class="nav-item" role="presentation">
				  <button class="nav-link" id="related-tab" data-bs-toggle="tab" data-bs-target="#related" type="button" role="tab" aria-controls="related" aria-selected="false">Công việc liên quan</button>
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
            
        </div> --}}
		
    </div>   
@endsection