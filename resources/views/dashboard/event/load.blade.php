<div class="table-responsive">
    <table class="table table-bordered table-hover bg-white text-center">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Title</th>
                <th>City</th>
                <th>Status</th>
                <th>Date</th>
                <th>Registration</th>
                <th>Paid</th>
                <th>Income</th>
                <th>Adspend</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="tbody">
            @foreach ($event as $e)
            <tr>
                <td>{{ $e->id }}</td>
                <td>{{ ucfirst($e->type) }}</td>
                <td>{{ $e->title }}</td>
                <td>{{ $e->city }}</td>
                <td>{{ $e->status }}</td>
                <td>{{ $e->event_date }}</td>
                <td>{{ $e->id }}</td>
                <td>{{ $e->id }}</td>
                <td>{{ $e->id }}</td>
                <td>{{ $e->adspend }}</td>
                <td>
                    <div class="dropdown">
                      <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="actions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                      <div class="dropdown-menu animated--fade-in" aria-labelledby="actions">
                        <a class="dropdown-item" href="{{ route('event.detail', $e->id )}}"><i class="fas fa-search text-success"></i> Detail</a>
                        <a class="dropdown-item" href="{{ route('event.edit', $e->id )}}"><i class="fas fa-edit text-primary"></i> Edit</a>
                        <button class="dropdown-item delete" id="{{ $e->id }}"><i class="fas fa-exclamation-triangle text-warning"></i> Non Aktif</button>
                      </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {!! $event->render() !!}
    </div>
</div>