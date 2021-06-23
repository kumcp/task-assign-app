@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form action="#">
                <div class="col-sm">
                    <label for="job_type">Loại công việc</label>
                    <select name="job_type" id="job_type">
                        <option value="all">Tất cả</option>
                        <option value="temp">Temp</option>
                    </select>
                    <label for="assigner">Người giao</label>
                    <select name="assigner" id="assigner">
                        <option value="all">Tất cả</option>
                        <option value="temp">Temp</option>
                    </select>
                    <label for="from_date">Từ ngày</label>
                    <input type="time" name="from_date" id="from_date">
                    
                </div>
                <div class="col-sm">
                    <label for="project">Dự án</label>
                    <select name="project" id="project">
                        <option value="all">Tất cả</option>
                        <option value="temp">Temp</option>
                    </select>
                    <label for="name">Tên công việc</label>
                    <input type="text" name="name" id="name">
                    <label for="to_date">Đến ngày</label>
                    <input type="time" name="to_date" id="to_date">
                </div>
            </form>
        </div>
        <div class="row">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link" href="#">Công việc trực tiếp xử lý</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Công việc liên quan</a>
                </li>
            </ul>
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
    </div>   
@endsection