@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-3">

    <h3 class="mb-4 fw-semibold">🕵️ System Activity Log</h3>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="q" class="form-control" placeholder="Cari user, aksi, IP..." value="{{ request('q') }}">
                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                <button class="btn btn-primary">Filter</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0" style="font-size: 0.9rem;">
                    <thead class="table-dark">
                        <tr>
                            <th>Waktu</th>
                            <th>User</th>
                            <th>Aksi</th>
                            <th>Deskripsi / Metadata</th>
                            <th>IP / Agent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td class="text-nowrap">{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
                            <td>
                                <strong>{{ $log->user->username ?? 'System' }}</strong><br>
                                <small class="text-muted">{{ $log->user->role->nama_role ?? '-' }}</small>
                            </td>
                            <td>
                                <span class="badge 
                                    @if(str_contains($log->aksi, 'Created')) bg-success 
                                    @elseif(str_contains($log->aksi, 'Updated')) bg-warning text-dark 
                                    @elseif(str_contains($log->aksi, 'Deleted')) bg-danger 
                                    @else bg-secondary @endif">
                                    {{ $log->aksi }}
                                </span>
                            </td>
                            <td>
                                <div class="mb-1">{{ $log->deskripsi }}</div>
                                
                                @if(!empty($log->meta_data))
                                <details>
                                    <summary class="small text-primary cursor-pointer">Lihat Detail Perubahan</summary>
                                    <pre class="bg-light p-2 mt-1 rounded border small" style="max-height: 200px; overflow:auto;">{{ json_encode($log->meta_data, JSON_PRETTY_PRINT) }}</pre>
                                </details>
                                @endif
                            </td>
                            <td>
                                <div>{{ $log->ip_address ?? '-' }}</div>
                                <div class="small text-muted text-truncate" style="max-width: 150px;" title="{{ $log->user_agent }}">
                                    {{ $log->user_agent ?? '-' }}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada log aktivitas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $logs->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

</div>
@endsection
