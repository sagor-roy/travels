<ul class="list">
    @foreach ($data as $item)
        <li><a onclick="selectAdds({{ $item->number }}, '{{ $item->name }}', '{{ $item->email }}', '{{ $item->gender }}')" href="javascript:void(0)">{{ $item->number }}</a></li>
    @endforeach
</ul>
