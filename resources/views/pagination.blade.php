@if ($paginator->hasPages())
<div class="row">
    <div class="col s12">
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
            @else
                <li class="waves-effect"><a href="{{ $paginator->previousPageUrl()}}"><i class="material-icons">chevron_left</i></a></li>
            @endif
            @for ($i=1; $i<=$paginator->lastPage();$i++)

            @if ($paginator->currentPage() === $i)
                <li class="active"><a href="{{$paginator->url($i)}}">{{$i}}</a></li>
            @else
                <li class="waves-effect"><a href="{{$paginator->url($i)}}">{{$i}}</a></li>
            @endif
            @endfor
            @if ($paginator->hasMorePages())
                <li class="waves-effect"><a href="{{$paginator->nextPageUrl()}}"><i class="material-icons">chevron_right</i></a></li>
            @else
                <li class="disabled"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
            @endif
        </ul>
    </div>
</div>

@endif
