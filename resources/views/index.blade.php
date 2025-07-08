@extends('layout')

@section('title', 'Recherche de magasins')

@section('content')
    <div class="search-container">
        <div class="search-header">
            <h1>Recherche de magasins</h1>
            <p>Trouvez les magasins dans votre zone géographique selon vos besoins</p>
        </div>

        <form method="GET" action="{{ route('results') }}" class="search-form">
            @if ($errors->any())
                <div class="errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-section">
                <h3>Zone géographique</h3>
                <p class="help-text">Définissez les limites de votre zone de recherche</p>

                <div class="bounds-grid">
                    <div class="input-group">
                        <label for="n">Latitude Nord</label>
                        <input type="number"
                               id="n"
                               name="n"
                               step="0.000001"
                               placeholder="48.8566"
                               value="{{ old('n') }}"
                               required />
                        <small>Ex: 48.8566 (Paris)</small>
                    </div>

                    <div class="input-group">
                        <label for="s">Latitude Sud</label>
                        <input type="number"
                               id="s"
                               name="s"
                               step="0.000001"
                               placeholder="48.8000"
                               value="{{ old('s') }}"
                               required />
                        <small>Ex: 48.8000</small>
                    </div>

                    <div class="input-group">
                        <label for="e">Longitude Est</label>
                        <input type="number"
                               id="e"
                               name="e"
                               step="0.000001"
                               placeholder="2.4000"
                               value="{{ old('e') }}"
                               required />
                        <small>Ex: 2.4000</small>
                    </div>

                    <div class="input-group">
                        <label for="w">Longitude Ouest</label>
                        <input type="number"
                               id="w"
                               name="w"
                               step="0.000001"
                               placeholder="2.3000"
                               value="{{ old('w') }}"
                               required />
                        <small>Ex: 2.3000</small>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Services recherchés</h3>
                <p class="help-text">Sélectionnez les services qui vous intéressent (optionnel)</p>

                <div class="filters">
                    <div class="input-group">
                        <label for="services">Services</label>
                        <select multiple name="services[]" id="services" size="10">
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}"
                                        {{ in_array($service->id, old('services', [])) ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="operator">Opérateur</label>
                        <select name="operator" id="operator">
                            <option value="OR" {{ old('operator', 'OR') === 'OR' ? 'selected' : '' }}>
                                OU - Au moins un service
                            </option>
                            <option value="AND" {{ old('operator') === 'AND' ? 'selected' : '' }}>
                                ET - Tous les services
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Rechercher les magasins
                </button>
                <button type="reset" class="btn btn-secondary">
                    Réinitialiser
                </button>
            </div>
        </form>
    </div>

    <style>
        #services {
            height: 200px;
        }

        .search-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .search-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .search-header h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 2.5em;
        }

        .search-header p {
            color: #666;
            font-size: 1.1em;
        }

        .search-form {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .errors {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .errors ul {
            margin: 0;
            padding-left: 20px;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 1.3em;
        }

        .help-text {
            color: #666;
            margin-bottom: 20px;
            font-size: 0.9em;
        }

        .bounds-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .filters {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
        }

        .input-group label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .input-group input,
        .input-group select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
        }

        .input-group small {
            color: #666;
            font-size: 0.8em;
            margin-top: 5px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
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
            .bounds-grid {
                grid-template-columns: 1fr;
            }

            .filters {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .search-form {
                padding: 20px;
            }
        }
    </style>
@endsection
