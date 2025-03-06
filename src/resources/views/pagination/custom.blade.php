<div class="pagination">
    <ul class="pagination">
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
        <li class="{{ ($paginator->currentPage() == $page) ? 'active' : '' }}">
            <a href="{{ $url }}">{{ $page }}</a>
        </li>
        @endforeach
    </ul>
</div>