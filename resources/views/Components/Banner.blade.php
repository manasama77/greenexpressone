<div id="slick_slider" class="shadow">
    @foreach ($banners as $banner)
        <div>
            <img src="{{ $banner->picture }}" alt="" loading="eager"
                onClick="window.location.replace('{{ $banner->url }}')">
        </div>
    @endforeach
</div>
