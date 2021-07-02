@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <form action="#" class="w-100">
                    <div class="form-group-row mb-3">
                        @include('components.input-date', [
                            'type' => 'month',
                            'name' => 'month', 
                            'label' => 'Tháng',
                        ])
                        {{-- <label for="month" class="mr-5">Tháng</label>
                        <input type="month" name="month" id="month">     --}}
                    </div>
    
                    <div class="form-group-row mb-3">
                        @include('components.select', [
                            'name' => 'assignee',
                            'label' => 'Người xử lý',
                            'options' => ['Hoàng Quân', 'Quân', 'ABC', 'XYZ']
                        ])
                        {{-- <label for="assignee" class="mr-5">Người xử lý</label>
                        <select name="assignee" id="assignee">
                            <option value="ABC">ABC</option>
                            <option value="XYZ">XYZ</option>
                        </select>     --}}
                    </div>
    
                    <div class="form-group-row mb-3">
                        @include('components.input-number', [
                            'name' => 'assign_amount', 
                            'label' => 'KL giao',
                        ])
                        {{-- <label for="assign_amount"  class="mr-5">KL giao</label>
                        <input type="number" name="assign_amount" id="assign_amount">     --}}
                    </div>
    
                    <div class="form-group-row mb-3">
                        @include('components.input-number', [
                            'name' => 'old_confirm_amount', 
                            'label' => 'KL cũ đã xác nhận',
                        ])
                        @include('components.input-number', [
                            'name' => 'old_confirm_percentage', 
                            'label' => '% đã xác nhận',
                        ])

                    </div>
                    <div class="form-group-row mb-3">
                        @include('components.input-number', [
                            'name' => 'request_amount', 
                            'label' => 'KL đề nghị',
                        ])
                        @include('components.input-number', [
                            'name' => 'request_percentage', 
                            'label' => '% đề nghị',
                        ])

                    </div>
                    <div class="form-group-row mb-3">
                        @include('components.input-number', [
                            'name' => 'confirm_amount', 
                            'label' => 'KL CV',
                        ])
                        @include('components.input-number', [
                            'name' => 'confirm_percentage', 
                            'label' => '% hoàn thành',
                        ])

                    </div>
                    <div class="form-group-row mb-3">
                        @include('components.select', [
                            'name' => 'quality',
                            'label' => 'Chất lượng',
                            'options' => ['Tốt', 'Trung bình', 'Kém'],
                        ])
  
                    </div>
  
                    <div class="form-group-row mb-5">
                        @include('components.text-area', [
                            'name' => 'note',
                            'label' => 'Nhận xét',
                        ])

                    </div>
                    <div class="btn-group offset-4" role="group">
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-save"></i>
                            <span>Lưu</span>
                        </button>
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-trash"></i>
                            <span>Xóa</span>
                        </button>
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Timesheet</span> 	
                        </button>
                    </div>
                </form>
                
            </div>

            <div class="col-md-3">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Tháng</th>
                        <th scope="col">Đối tượng xử lý</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Nguyen Van A</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Nguyen Van B</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Nguyen Van C</td>
                        </tr>
                        
                    </tbody>
                  </table>
            </div>
        </div>
        

    </div>
    
@endsection