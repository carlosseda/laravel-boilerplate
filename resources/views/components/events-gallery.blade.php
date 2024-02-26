@props(['events'])

<section class="events-gallery">
  <div class="events-gallery-title">
    <h2>Próximos eventos</h2>
  </div>
  <div class="events-gallery-items">
    @foreach($events as $event)
      <a href="{{ route('event', $event->id)}}">
        <div class="events-gallery-item">
          <div class="events-gallery-item-image">
    
          </div>
          <div class="events-gallery-item-title">
            <h3>{{ $event->title }}</h3>
          </div>
          <div class="events-gallery-item-information">
            <div class="events-gallery-item-price">
              <span>{{ $event->price }}€</span>
            </div>
            <div class="events-gallery-item-date">
              <span>{{  \Carbon\Carbon::parse($event->start_date)->format('d-m-y') }}</span>
              <span>{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span>
            </div>
          </div>
        </div>
      </a>
    @endforeach
  </div>
</section>


                      