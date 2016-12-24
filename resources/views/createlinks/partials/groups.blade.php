<select id="group-selector" onchange="updateRadio()">
    @foreach($groups as $group)
        <option>{{$group->option}}</option>
    @endforeach
</select>  