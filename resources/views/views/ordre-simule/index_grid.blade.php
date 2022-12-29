@extends('layouts.app')
@section('css')

@endsection

@section('content')

<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="card widget-inline">
                <div class="card-body p-0 my-2 mx-2 fw-bold">
                    <div class="row g-0">
                        
                    <form action="{{route('ordre_simule.index',[$algo,'grid'])}}" method="GET">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <label for="date_deb">Groupe de Titres</label>
                                <select name="groupe_id" id="groupe_id" class="form-select">
                                    @if(isset($_GET['groupe_id']) && $_GET['groupe_id'] != "")
                                        <option value="{{ $_GET['groupe_id']}}">{{$groupe_select->nom}}</option>
                                    @endif
                                    <option value="">Tous</option>
                                    
                                    @foreach ($groupes as $groupe)
                                        <option value="{{$groupe->id}}">{{$groupe->nom}}</option>                                        
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <label for="date_deb"> Titres</label>
                                <select name="action_id" id="action_id" class="form-select">
                                    @if(isset($_GET['action_id']) && $_GET['action_id'] != "")
                                        <option value="{{ $_GET['action_id']}}">{{$action_select->nom}}</option>
                                    @endif
                                    <option value="">Tous</option>
                                    
                                    @foreach ($actions as $action)
                                        <option value="{{$action->action_id}}">{{$action->nom}}</option>                                        
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <label for="date_deb"> Date de début</label>
                              <input type="date" class="form-control" id="date_deb" min="2022-11-14" max="{{date("Y-m-d")}}" @if(isset($_GET['date_deb'])) value="{{$_GET['date_deb']}}" @endif name="date_deb" placeholder="Date début">
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <label for="date_fin"> Date de fin</label>
                                <input type="date" class="form-control" id="date_fin" min="2022-11-14" max="{{date("Y-m-d")}}" @if(isset($_GET['date_fin'])) value="{{$_GET['date_fin']}}" @endif name="date_fin" placeholder="Date fin">
                            </div>
                            <div class="col-sm-4 col-md-2">
                                <label for="">&nbsp;</label>
                                <input type="submit" class="form-control btn btn-danger" value="Valider">
                            </div>
                          </div>                        
                            
                    </form>

                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-box-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->


    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    
                    
                    <div class="row">
                        <div class="col-12 text-center mb-2">
                            <h4 class="header-title mb-3">Simulation des Ordres</h4> 
                            <span class="text-muted fw-bold">@if($action_select != null ) {{$action_select->nom}} @else Tous les titres @endif  </span>
                            <span class="text-danger fw-bold"> @if($nb_jours_select > 0 ) Sur {{$nb_jours_select}} jours @else @if(isset($_GET['date_deb']) && $_GET['date_deb']!= "") pour la journée du {{string_to_date($_GET['date_deb'])}} @else Aujourd'hui @endif @endif</span>
                            
                        </div>
                        <div class="col-4">
                            <p class="text-muted mb-3 text-primary "  >
                                <a  @if($algo != null) href="{{route('ordre_simule.index', $algo)}} @else href="{{route('ordre_simule.index')}}  @endif " style="text-decoration: underline; font-size: 15px; ">Changer l'affichage: <i style="font-size: 25px; " class="mdi mdi-format-list-bulleted-square"></i>  </a> 
                            </p>
                        </div>
                        <div class="col-4">
                            <p class="text-muted fw-bold text-primary " style="font-size:20px"  >
                              <span class="clignote"> Portefeuille</span>   : <span class="  text-primary">{{round($portefeuille,3)}} </span> 
                            </p>
                        </div>
                        <div class="col-4">
                            <p class="text-muted fw-bold text-primary " style="font-size:20px"  >
                              <span class="clignote"> Gains</span>   : <span class="  @if($gains >= 0) text-success @else text-danger @endif">{{round($gains,3)}} </span> 
                            </p>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane show active" id="bordered-tabs-preview">
                            <ul class="nav nav-tabs nav-bordered mb-3">
                                <li class="nav-item">
                                    <a href="#home-b1" data-bs-toggle="tab" aria-expanded="false"
                                        class="nav-link active">
                                        <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Achetés</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#profile-b1" data-bs-toggle="tab" aria-expanded="true" class="nav-link ">
                                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Vendus</span>
                                    </a>
                                </li>

                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane show active" id="home-b1">
                                    @include('ordre-simule.index_achete_grid')
                                </div>
                                <div class="tab-pane " id="profile-b1">
                                    @include('ordre-simule.index_vendu_grid')

                                </div>
                            </div>
                        </div> <!-- end preview-->


                    </div> <!-- end tab-content-->
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->



        <div class="row py-4">
            <div class="col-12 text-center">
                <i class="mdi mdi-dots-circle mdi-spin font-24 text-muted"></i>
            </div>
        </div>

        <style>
            .typeachat {
                background-color: #17a2b8;
                color: #fff;
                font-weight: bold;
                padding: 5px;
                border-radius: 5px;
            }

            .typevente {
                background-color: #dc3545;
                color: #fff;
                font-weight: bold;
                padding: 5px;
                border-radius: 5px;
            }

            .border {
                border: 1px solid #094077 !important;
                border-style: dashed !important;
                border-width: 2px !important;
                background-color: beige;
            }

        </style>

    </div> <!-- End Content -->

    @endsection

    @section('script')
    <script>
        $('.autre_champs').hide();



        $('#action_id').change(function () {

            console.log($('#action_id').val());
            if ($('#action_id') != "") {
                $('.autre_champs').fadeIn(1000);
            }
        })


        $("input[name='type_ordre']").click(function (e) {

            if (e.currentTarget.value == "achat") {
                $('#typeachat').addClass('typeachat');
                $('#typevente').removeClass('typevente');

            } else {
                $('#typevente').addClass('typevente');

                $('#typeachat').removeClass('typeachat');

            }
        })

        function getOrdre(ordre_id) {

            $.get("/get-ordre/" + ordre_id, function (data) {

                $('#nom_action').html(data.action.nom + " N°" + data.numero);
                $('#valeur_achat').html("Valeur d'achat: " + data.valeur_action + " €");
                $('#ordre_id').val(data.id);
            });

        }

        function getOrdreVendu(ordre_id) {

            $.get("/get-ordre/" + ordre_id, function (data) {

                $('#nom_action_modifier1').html(data.action.nom + " N°" + data.numero);
                $('#valeur_action_modifier1').val(data.valeur_action);
                $('#frais_modifier1').val(data.frais_vente);
                $('#date_modifier1').val(data.date_vente);
                $('#ordre_id_modifier1').val(data.id);

            });

        }

        function getOrdreAchete(ordre_id) {

            $.get("/get-ordre/" + ordre_id, function (data) {

                $('#nom_action_modifier').html(data.action.nom + " N°" + data.numero);
                $('#valeur_action_modifier').val(data.valeur_action);
                $('#date_validite_modifier').val(data.date_validite.substr(0, 10));
                $('#frais_achat_modifier').val(data.frais_achat);
                $('#quantite_modifier').val(data.quantite);
                $('#paiement_modifier').append($('<option>', {
                    value: data.paiement,
                    text: data.paiement
                }));
                $('#ordre_id_modifier').val(data.id);

            });

        }

    </script>
    @endsection
