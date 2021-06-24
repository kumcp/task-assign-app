@extends('layouts.app')

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


                        {{-- <div class="d-flex">
                            <div>
                                <label for="job_type">Loại công việc</label>
                                <select name="job_type" id="job_type">
                                    <option value="project">Dự án</option>
                                    <option value="training">Training</option>
                                </select>
                            </div>
                            <div>
                                <div class="d-inline ml-5">
                                    <label for="period">Kỳ</label>
                                    <input type="text" name="period" id="period">
                                    <select name="period_unit" id="period_unit">
                                        <option value="Ngày">Ngày</option>
                                        <option value="Tháng">Tháng</option>
                                        <option value="Năm">Năm</option>
                                    </select>
                                </div>
                                
                            </div>

                        </div> --}}
                        
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
                        {{-- <label for="parent_job">Việc cha</label>
                        <select name="parent_job" id="parent_job">
                            <option value="ABC">ABC</option>
                            <option value="ABC">ABC</option>
                            <option value="ABC">ABC</option>
                            <option value="ABC">ABC</option>
                        </select> --}}
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
                        {{-- <div class="d-inline">
                            <label for="job_code">Mã CV</label>
                            <input type="text" name="job_code" id="job_code">
                            <label for="priorities">Độ ưu tiên</label>
                            <select name="priorities" id="priorities">
                                <option value="ABC">ABC</option>
                                <option value="XYZ">XYZ</option>
                                <option value="DEF">DEF</option>
                            </select>
                        </div> --}}

                    </div>
                    <div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'job_name', 
							'label' => 'Tên công việc'
						])
                        {{-- <label for="job_name">Tên công việc</label>
                        <input type="text" name="job_name" id="job_name"> --}}
                    </div>
                    <div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'lsx_amount', 
							'label' => 'Khối lượng LSX'
						])
                        {{-- <label for="lsx_amount">Khối lượng LSX</label>
                        <input type="text" name="lsx_amount" id="lsx_amount"> --}}
                        <label>(Man day)</label>
                    </div>
                    <div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'assign_amount', 
							'label' => 'Khối lượng giao'
						])
						{{-- <label for="assign_amount">Khối lượng giao</label>
                        <input type="text" name="assign_amount" id="assign_amount"> --}}
                        <label>(Man day)</label>
                    </div>
                    <div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'deadline', 
							'label' => 'Hạn xử lý',
						])
						{{-- <label for="deadline">Hạn xử lý</label>
                        <input type="date" name="deadline" id="deadline"> --}}
                    </div>
                    <div class="form-group-row mb-3">
                        @include('components.text-area', [
							'name' => 'description',
							'label' => 'Mô tả CV',
						])
						{{-- <label for="description" class="col-sm-2 col-form-label">Mô tả CV</label>
                        <textarea name="description" id="description"></textarea> --}}
                    </div>
                    <div class="form-group-row mb-3">
                        @include('components.input-file', [
							'name' => 'file',
							'label' => 'Tệp nội dung',
						])
						{{-- <label for="file" class="col-sm-2 col-form-label">Tệp nội dung</label>
                        <input type="file" name="file" id="file" class="form-control-file d-inline"> --}}
                    </div>
              
                    
                    <div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'chu-tri', 
							'label' => 'Chủ trì'
						])
						{{-- <label for="chu-tri">Chủ trì</label>
                        <input type="text" name="chu-tri" id="chu-tri"> --}}
                    </div>
                    <div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'phoi-hop', 
							'label' => 'Phối hợp'
						])
						{{-- <label for="phoi-hop">Phối hợp</label>
                        <input type="text" name="phoi-hop" id="phoi-hop"> --}}
                    </div>
                    <div class="form-group-row mb-3">
						@include('components.input-text', [
							'name' => 'nhan-xet', 
							'label' => 'Theo dõi, nhận xét'
						])
						{{-- <label for="nhan-xet">Theo dõi, nhận xét</label>
                        <input type="text" name="nhan-xet" id="nhan-xet"> --}}
                    </div>
                    
                    @include('components.buttons', ['buttons' => ['Lưu', 'Lưu sao', 'Sửa', 'Xóa', 'Tìm kiếm']])
                    
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
    
@endsection