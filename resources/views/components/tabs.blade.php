@props(['tabs' => []])

<div class="tabs">
  @foreach ($tabs as $key => $label)
    <div class="tab {{ $loop->first ? 'active' : '' }}" data-tab="{{ $key }}">
      <button>{{ $label }}</button>
    </div>
  @endforeach
</div>