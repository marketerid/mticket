<option value="">Pilih Jasa Pengiriman</option>
@foreach($shipments as $shipment)
    <option data-costs="{{ json_encode($shipment->costs) }}" value="{{ $shipment->code }}" {{ (isset($shipmentCode) AND $shipmentCode == $shipment->code) ? "selected" : "" }}>{{ $shipment->name }}</option>
@endforeach