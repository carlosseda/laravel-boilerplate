@props(['event'])

<div class="event">
  <div class="event-image">
    
  </div>
  <div class="event-title">
    <h3>{{ $event->title }}</h3>
  </div>
  <div class="event-information">
    <div class="event-price">
      <span>{{ $event->price }}€</span>
    </div>
    <div class="event-date">
      <span>
        Desde {{  \Carbon\Carbon::parse($event->start_date)->format('d-m-y') }} a las
        {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span>
    </div>
  </div>
  <div class="event-description">
    <p>{{ $event->description }}</p>
  </div>
</div>