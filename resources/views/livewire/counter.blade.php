<div>
    <h1>{{ $count }}</h1>
    {{ $title }}

    <button class="btn btn-primary btn-sm" wire:click="increment">+</button>

    <button class="btn btn-secondary btn-sm" wire:click="decrement">-</button>
</div>
@section('top-js')
    <script>
        console.log('1')
    </script>
@endsection
