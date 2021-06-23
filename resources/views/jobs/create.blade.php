@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
        
            <div class="col-8">
                <form>
                    
                    <div class="form-group">
                        <label for="assigner">Người giao việc</label>
                        <input type="text" class="form-control" id="assigner" placeholder="Nhập tên">    
                    </div>
                    <div class="form-group">
                        <label for="project_code">Mã dự án</label>
                        <input type="text" class="form-control" id="project_code" placeholder="Nhập mã dự án">  
                    </div>
                    <div class="form-group">
                        <div class="d-flex">
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

                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label for="parent_job">Việc cha</label>
                        <select name="parent_job" id="parent_job">
                            <option value="ABC">ABC</option>
                            <option value="ABC">ABC</option>
                            <option value="ABC">ABC</option>
                            <option value="ABC">ABC</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="d-inline">
                            <label for="job_code">Mã CV</label>
                            <input type="text" name="job_code" id="job_code">
                            <label for="priorities">Độ ưu tiên</label>
                            <select name="priorities" id="priorities">
                                <option value="ABC">ABC</option>
                                <option value="XYZ">XYZ</option>
                                <option value="DEF">DEF</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="job_name">Tên công việc</label>
                        <input type="text" name="job_name" id="job_name">
                    </div>
                    <div class="form-group">
                        <label for="lsx_amount">Khối lượng LSX</label>
                        <input type="text" name="lsx_amount" id="lsx_amount">
                        <label>(Man day)</label>
                    </div>
                    <div class="form-group">
                        <label for="assign_amount">Khối lượng giao</label>
                        <input type="text" name="assign_amount" id="assign_amount">
                        <label>(Man day)</label>
                    </div>
                    <div class="form-group">
                        <label for="deadline">Hạn xử lý</label>
                        <input type="date" name="deadline" id="deadline">
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả CV</label>
                        <textarea name="description" id="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="file">Tệp nội dung</label>
                        <input type="file" name="file" id="file">
                    </div>
              
                    
                    <div class="form-group">
                        <label for="chu-tri">Chủ trì</label>
                        <input type="text" name="chu-tri" id="chu-tri">
                    </div>
                    <div class="form-group">
                        <label for="phoi-hop">Phối hợp</label>
                        <input type="text" name="phoi-hop" id="phoi-hop">
                    </div>
                    <div class="form-group">
                        <label for="nhan-xet">Theo dõi, nhận xét</label>
                        <input type="text" name="nhan-xet" id="nhan-xet">
                    </div>
                    
                    
                    <div class="form-group form-check">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1">
                      <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
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