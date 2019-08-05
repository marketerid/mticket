<option value="">Pilih Kota</option>
@foreach($cities as $city)
    <option value="{{ $city->city_id }}" {{ (isset($cityId) AND $cityId == $city->city_id) ? "selected" : "" }}>{{ $city->city_name }}</option>
@endforeach