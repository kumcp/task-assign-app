<ul class="list-unstyled components">
    @foreach ($options as $option)
        <li>
            <a href="{{$option['link'] ?? '#'}}">{{$option['value'] ?? $option}}</a>
        </li>
    @endforeach
</ul>