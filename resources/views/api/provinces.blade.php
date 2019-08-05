<option value="">Pilih Provinsi</option>
@foreach($provinces as $province)
    <option value="{{ $province->province_id }}" {{ (isset($provinceId) AND $provinceId == $province->province_id) ? "selected" : "" }}>{{ $province->province }}</option>
@endforeach