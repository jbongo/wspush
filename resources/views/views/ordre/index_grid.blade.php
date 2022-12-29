@extends('layouts.app')
@section('css')

@endsection

@section('content')

<div class="content">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Ordres</li>
                    </ol>
                </div>
                <h4 class="page-title">Tous les ordres</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-6 col-xl-3">
                            <div class="card mb-0 h-100">
                                <div class="card-body" style="padding: 0.7rem 0.8rem">
                                    <div class="border-dashed border-2 border h-100 w-100 rounded d-flex align-items-center justify-content-center"
                                        data-bs-toggle="modal" data-bs-target="#addActionModal">
                                        <a href="javascript:void(0);" class="text-center text-muted p-2">
                                            <i class="mdi mdi-plus h3 my-0"></i>
                                            <h4 class="font-16 mt-1 mb-0 d-block text-primary">Passer un ordre d'achat
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                </div>

                <div class="col-12">
                    @if($errors->any())
                        <div class="text-danger">
                            {!! implode('', $errors->all()) !!}

                        </div>
                    @endif
                </div>

            </div>
        </div>


    </div>




    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Ordres</h4>
                    <p class="text-muted mb-3 text-primary "  >
                        <a href="{{route('ordre.index')}} " style="text-decoration: underline; font-size: 15px; ">Changer l'affichage: <i style="font-size: 25px; " class="mdi mdi-format-list-bulleted-square"></i>  </a> 
                    </p>

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
                                    @include('ordre.index_achete_grid')
                                </div>
                                <div class="tab-pane " id="profile-b1">
                                    @include('ordre.index_vendu_grid')

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
