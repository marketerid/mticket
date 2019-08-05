<option value="">Pilih Kecamatan</option>
@foreach($districts as $district)
    <option value="{{ $district->subdistrict_id }}" {{ (isset($districtId) AND $districtId == $district->subdistrict_id) ? "selected" : "" }}>{{ $district->subdistrict_name }}</option>
@endforeach