@extends('layout')

@section('content')
    <div class="results-container">
        <div class="search-summary">
            <h2>Résultats de recherche</h2>
            <p>
                <strong>Zone de recherche :</strong>
                Nord: {{ $bounds['n'] }}, Sud: {{ $bounds['s'] }},
                Est: {{ $bounds['e'] }}, Ouest: {{ $bounds['w'] }}
            </p>
            @if(!empty($selectedServices))
                <p>
                    <strong>Services :</strong>
                    @php
                        $selectedServiceNames = $services->whereIn('id', $selectedServices)->pluck('name');
                    @endphp
                    {{ $selectedServiceNames->implode(', ') }}
                    <strong>({{ $operator }})</strong>
                </p>
            @endif
            <p><strong>{{ $stores->count() }}</strong> magasin(s) trouvé(s)</p>
        </div>

        @if($stores->isEmpty())
            <div class="no-results">
                <p>Aucun magasin trouvé dans cette zone avec les critères sélectionnés.</p>
                <a href="{{ route('index') }}" class="btn btn-primary">Nouvelle recherche</a>
            </div>
        @else
            <div class="stores-list">
                @foreach($stores as $store)
                    <div class="store-card">
                        <div class="store-header">
                            <h3>
                                <a href="{{ route('store.show', $store->id) }}" class="store-name">
                                    {{ $store->name }}
                                </a>
                            </h3>
                            <span class="store-status {{ $store->isOpen() ? 'open' : 'closed' }}">
                                {{ $store->isOpen() ? 'Ouvert' : 'Fermé' }}
                            </span>
                        </div>

                        <div class="store-address">
                            <p>{{ $store->full_address }}</p>
                        </div>

                        @if($store->services->isNotEmpty())
                            <div class="store-services">
                                <strong>Services proposés :</strong>
                                <ul>
                                    @foreach($store->services as $service)
                                        <li>{{ $service->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <div class="back-to-search">
            <a href="{{ route('index') }}" class="btn btn-secondary">Nouvelle recherche</a>
        </div>
    </div>

    <style>
        .results-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .search-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .search-summary h2 {
            margin-top: 0;
            color: #333;
        }

        .stores-list {
            display: grid;
            gap: 20px;
        }

        .store-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .store-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .store-name {
            color: #007bff;
            text-decoration: none;
            font-size: 1.2em;
            font-weight: bold;
        }

        .store-name:hover {
            text-decoration: underline;
        }

        .store-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: bold;
        }

        .store-status.open {
            background: #d4edda;
            color: #155724;
        }

        .store-status.closed {
            background: #f8d7da;
            color: #721c24;
        }

        .store-address {
            margin-bottom: 15px;
        }

        .store-address p {
            margin: 0;
            color: #666;
        }

        .store-services ul {
            list-style: none;
            padding: 0;
            margin: 10px 0 0 0;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .store-services li {
            background: #e9ecef;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.9em;
        }

        .no-results {
            text-align: center;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .back-to-search {
            margin-top: 30px;
            text-align: center;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
@endsection
