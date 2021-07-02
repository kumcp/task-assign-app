<table class="table table-bordered">
    <thead>
      <tr>
        @foreach ($cols as $col)
            <th scope="col">{{$col}}</th>
        @endforeach
        
        @isset($checkbox)
            <th scope="col"><input type="checkbox" name="{{$checkbox}}"></th>
        @endisset
            
      </tr>
    </thead>
    <tbody>
        @foreach ($rows ?? [] as $row)
            <tr>
                @foreach ($row as $field)
                    <td>{{$field}}</td>
                @endforeach
                
                @isset ($checkbox)
                    <td><input type="checkbox" name="{{$checkbox}}"></td>
                @endisset        
            </tr>

        @endforeach
    </tbody>
</table>