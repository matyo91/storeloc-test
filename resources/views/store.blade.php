@extends('layout')

@section('content')
    <div class="store-container">
        <div class="store-header">
            <h1>{{ $store->name }}</h1>
            <div class="store-status {{ $store->isOpen() ? 'open' : 'closed' }}">
                <span class="status-indicator"></span>
                {{ $store->isOpen() ? 'Ouvert' : 'Fermé' }}
            </div>
        </div>

        <div class="store-content">
            <div class="store-info">
                <div class="info-section">
                    <h3>Adresse</h3>
                    <p>{{ $store->full_address }}</p>
                    <p>Pays: {{ $store->country_code }}</p>
                </div>

                <div class="info-section">
                    <h3>Coordonnées géographiques</h3>
                    <p>Latitude: {{ $store->lat }}</p>
                    <p>Longitude: {{ $store->lng }}</p>
                </div>

                @if($store->services->isNotEmpty())
                    <div class="info-section">
                        <h3>Services proposés</h3>
                        <div class="services-list">
                            @foreach($store->services as $service)
                                <span class="service-tag">{{ $service->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="info-section">
                    <h3>Horaires d'ouverture</h3>
                    <div class="hours-table">
                        @foreach($store->hours as $day => $hours)
                            <div class="day-row">
                                <span class="day-name">{{ \App\Helpers\DateHelper::translateDay($day) }}</span>
                                <span class="day-hours">
                                    @if(is_array($hours))
                                        {{ implode(', ', $hours) }}
                                    @else
                                        {{ $hours }}
                                    @endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="store-actions">
            <a href="{{ route('index') }}" class="btn btn-secondary">Nouvelle recherche</a>
            <a href="{{ route('results') }}?n={{ request('n', '') }}&s={{ request('s', '') }}&e={{ request('e', '') }}&w={{ request('w', '') }}&services={{ request('services', '') }}&operator={{ request('operator', '') }}" class="btn btn-primary">Retour aux résultats</a>
        </div>
    </div>

    <style>
        .store-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .store-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .store-header h1 {
            margin: 0;
            color: #333;
            font-size: 2.5em;
        }

        .store-status {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 1.1em;
        }

        .store-status.open {
            background: #d4edda;
            color: #155724;
        }

        .store-status.closed {
            background: #f8d7da;
            color: #721c24;
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: currentColor;
        }

        .store-content {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .store-info {
            padding: 30px;
        }

        .info-section {
            margin-bottom: 30px;
        }

        .info-section:last-child {
            margin-bottom: 0;
        }

        .info-section h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.3em;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }

        .info-section p {
            margin: 8px 0;
            color: #666;
            font-size: 1.1em;
        }

        .services-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .service-tag {
            background: #007bff;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 500;
        }

        .hours-table {
            display: grid;
            gap: 8px;
        }

        .day-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .day-row:last-child {
            border-bottom: none;
        }

        .day-name {
            font-weight: bold;
            color: #333;
            min-width: 120px;
        }

        .day-hours {
            color: #666;
            text-align: right;
        }

        .store-actions {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
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
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        @media (max-width: 768px) {
            .store-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .store-header h1 {
                font-size: 2em;
            }

            .day-row {
                flex-direction: column;
                gap: 5px;
            }

            .day-hours {
                text-align: left;
            }

            .store-actions {
                flex-direction: column;
            }
        }
    </style>
@endsection
