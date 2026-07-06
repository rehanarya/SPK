@props(['status' => 'pending'])

@php
    $map = [
        'diprioritaskan'         => ['class' => 'status-priority', 'label' => 'Diprioritaskan'],
        'diterima'               => ['class' => 'status-accept',   'label' => 'Diterima'],
        'diterima_tidak_prio'    => ['class' => 'status-accept-secondary', 'label' => 'Diterima'],
        'ditolak'                => ['class' => 'status-reject',   'label' => 'Ditolak'],
        'menunggu'               => ['class' => 'status-pending',  'label' => 'Menunggu'],
        'aktif'                  => ['class' => 'status-accept',   'label' => 'Aktif'],
        'tutup'                  => ['class' => 'status-reject',   'label' => 'Tutup'],
    ];
    $entry = $map[$status] ?? ['class' => 'status-pending', 'label' => ucfirst($status)];
@endphp

<span class="status-badge {{ $entry['class'] }}">{{ $entry['label'] }}</span>
