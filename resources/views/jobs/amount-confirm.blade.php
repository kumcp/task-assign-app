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
                        {{-- <label for="old_confirm_amount"  class="mr-5">KL cũ đã xác nhận</label>
                        <input type="number" name="old_confirm_amount" id="old_confirm_amount">   
                        <label for="old_confirm_percentage" class="mx-5">% đã xác nhận</label>
                        <input type="number" name="old_confirm_percentage" id="old_confirm_percentage">     --}}
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
                        {{-- <label for="request_amount"  class="mr-5">KL đề nghị</label>
                        <input type="number" name="request_amount" id="request_amount">    
                        <label for="request_percentage"  class="mx-5">% đề nghị</label>
                        <input type="number" name="request_percentage" id="request_percentage">    --}}
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
                        {{-- <label for="confirm_amount"  class="mr-5">Khối lượng CV</label>
                        <input type="number" name="confirm_amount" id="confirm_amount">  
                        <label for="confirm_percentage" class="mx-5">% hoàn thành</label>
                        <input type="number" name="confirm_percentage" id="confirm_percentage">    --}}
                    </div>
                    <div class="form-group-row mb-3">
                        @include('components.select', [
                            'name' => 'quality',
                            'label' => 'Chất lượng',
                            'options' => ['Tốt', 'Trung bình', 'Kém'],
                        ])
                        {{-- <label for="quality" class="mr-5">Chất lượng</label>
                        <select name="quality" id="quality">
                            <option value="Tốt">Tốt</option>
                            <option value="Trung bình">Trung bình</option>
                            <option value="Kém">Kém</option>
                        </select>     --}}
                    </div>
  
                    <div class="form-group-row">
                        @include('components.text-area', [
                            'name' => 'note',
                            'label' => 'Nhận xét',
                        ])
                        {{-- <label for="note" class="mr-5">Nhận xét</label>
                        <textarea name="note" id="note" class="form-control"></textarea> --}}
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