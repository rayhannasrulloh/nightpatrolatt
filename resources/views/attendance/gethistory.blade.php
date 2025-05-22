@if ($history->isEmpty())
<div class="alert alert-warning">
    <strong>Warning!</strong> No attendance history found.
</div>
@endif

@foreach ($history as $d)
<ul class="listview image-listview">
    <li>
        <div class="item">
            @php
                $path = Storage::url('uploads/attendance/' . $d->photo_in);
            @endphp
            <img src="{{ url($path) }}" alt="image" class="image">
            <div class="in">
                <div>
                    <b>{{ date("d-m-Y",strtotime($d->attd_date)) }}</b><br>
                    {{-- <small>{{ $d->position }}</small> --}}
                </div>
                <span class="badge {{ $d->clock_in < "00:00" ? "bg-success" : "bg-danger" }}  ">
                    {{ $d->clock_in }}
                </span>
            </div>
        </div>
    </li>
</ul>
@endforeach