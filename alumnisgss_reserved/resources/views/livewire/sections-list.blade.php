<div>
    @include('passive-components.section-link', $section = [ 'shortname' => '', 'title' => 'Homepage'])
    @foreach ( $sections as $s )
        @include('passive-components.section-link', $section = [ 'shortname' => 's/' . $s->shortname, 'title' => $s->title ])
    @endforeach
    @include('passive-components.section-link', $section = [ 'shortname' => 'logout', 'title' => 'Logout'])
</div>
