<option value="">Pilih Layanan Pengiriman</option>
@foreach($shipments as $shipment)
    @if($shipment->code == $serviceCode)
        @foreach($shipment->costs as $cost)
            <option value="{{ $cost->service }}" {{ (isset($servicePackage) AND $servicePackage == $cost->service) ? "selected" : "" }}>{{ $cost->service }} - {{ $cost->description }} ({{ number_format($cost->cost[0]->value,0) }}/kg {{ $cost->cost[0]->etd }} hari)</option>
        @endforeach
    @endif
@endforeach