@extends('layouts.app')
@section('css')
    <link href="{{asset('assets/css/vendor/dataTables.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/vendor/responsive.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="content">
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card widget-inline">
                <div class="card-body p-0 my-2 mx-2 fw-bold">
                    <div class="row g-0">
                        
                    <form action="{{route('ordre.index')}}" method="GET">
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
    <div class="card">
        <div class="card-body">
            <div class="col-12">
                <div class="row">    
                  
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
                    <div class="row">
                    
                        <div class="col-sm-6 col-xl-3">
                            <div class="card mb-0 ">
                                <div class="card-body" style="padding: 0.1rem 0.8rem">
                                    <div class="border-dashed border-2 border rounded d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#addActionModal">
                                        <a href="javascript:void(0);" class="text-center text-muted p-2" >
                                            <i class="mdi mdi-plus h3 my-0"></i> <h4 class="font-16 mt-1 mb-0 d-block text-primary">Passer un ordre d'achat</h4>
                                        </a>
                                    </div>
                                </div> 
                            </div> 
                        </div> 
                        
                        <div class="col-12 text-center mb-2">
                            <h4 class="header-title mb-3">Ordres réels</h4> 
                            <span class="text-muted fw-bold">@if($action_select != null ) {{$action_select->nom}} @else Tous les titres @endif  </span>
                            <span class="text-danger fw-bold"> @if($nb_jours_select > 0 ) Sur {{$nb_jours_select}} jours @else @if(isset($_GET['date_deb']) && $_GET['date_deb']!= "") pour la journée du {{string_to_date($_GET['date_deb'])}} @else Aujourd'hui @endif @endif</span>
                            
                        </div>
                        <div class="col-4">
                            <p class="text-muted text-primary "  >
                                <a href="{{route('ordre.index', 'grid')}} " style="text-decoration: underline; font-size: 15px; ">Changer l'affichage: <i style="font-size: 25px; " class="mdi  mdi-view-grid "></i>  </a> 
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
                                    <a href="#home-b1" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                        <span class="d-none d-md-block">Achetés</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#profile-b1" data-bs-toggle="tab" aria-expanded="true" class="nav-link ">
                                        <span class="d-none d-md-block">Vendus</span>
                                    </a>
                                </li>
                               
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane show active" id="home-b1">
                                    @include('ordre.index_achete_liste')
                                </div>
                                <div class="tab-pane " id="profile-b1">
                                    @include('ordre.index_vendu_liste')                                   
                                </div>
                            </div>                                          
                        </div> <!-- end preview-->
                    
                    
                    </div> <!-- end tab-content-->
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->

    
    <!-- Modal Add action -->
    <div class="modal fade" id="addActionModal" tabindex="-1" aria-labelledby="addActionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('ordre.store_achat')}}" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addActionModalLabel">Passer un ordre d'achat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                            @csrf
                            <div class="row" style="margin-top: 20px">
                                <div class="col-12" >
                                    <div id="" class="custom-control custom-radio custom-control-inline">
                                        <label class="custom-control-label" for="achat">Choisissez l'action</label>
                                        <select name="action_id" class="form-select" id="action_id_select" required>
                                            
                                            <option value=""></option>
                                            @foreach ($actions as $action )
                                                
                                                <option value="{{$action->id}}">{{$action->nom}}</option>
                                            @endforeach
                                        </select>
                                    </div>                                        
                                </div>
                                
                                
                            </div>
                            {{-- <div class="row autre_champs" style="margin-top: 20px">
                                <div class="col-6" >
                                    <div id="typeachat" class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="achat" name="type_ordre" value="achat" required class="form-check-input">
                                        <label class="custom-control-label" for="achat">Achat</label>
                                    </div>                                        
                                </div>
                                <div class="col-6">
                                    <div id="typevente" class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="vente" name="type_ordre" value="vente" class="form-check-input">
                                        <label class="custom-control-label" for="vente">Vente</label>
                                    </div>
                                </div>
                                
                            </div> --}}
                            
                            <div class="row autre_champs" style="margin-top: 20px">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="valeur_action" class="form-label">Valeur</label>
                                        <input type="number" step="0.0001" min="0" class="form-control" name="valeur_action" id="valeur_action"  required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="date_validite" class="form-label">Date de validité</label>
                                        <input type="date" class="form-control" name="date_validite" id="date_validite" min="{{date('Y-m-d')}}" required >
                                    </div>      
                                </div>
                            </div>
                            
                            <div class="row autre_champs" style="margin-top: 2px">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="quantite" class="form-label">Quantité</label>
                                        <input type="number"  min="0" class="form-control" name="quantite" id="quantite"  required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="date_validite" class="form-label">&nbsp;</label>
                                        <select name="paiement" class="form-select" id="paiement" required>
                                            <option value="comptant">comptant</option>
                                            <option value="srd">srd</option>
                                        </select>
                                    </div>      
                                </div>
                            </div>
                            
                            <div class="row autre_champs" style="margin-top: 2px">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="frais_achat" class="form-label">Frais</label>
                                        <input type="number" step="0.0001"  min="0" class="form-control" name="frais_achat" id="frais_achat"  required>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="date_achat" class="form-label">Date d'achat</label>
                                        <input type="date"  max="{{date('Y-m-d')}}" class="form-control" name="date_achat" id="date_achat"  required>
                                    </div>
                                </div>
                               
                            </div>
                            
                                                                
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </div>
            </form> 
        </div>
    </div>

    <div class="row py-4">
        <div class="col-12 text-center">
            <i class="mdi mdi-dots-circle mdi-spin font-24 text-muted"></i>
        </div>
    </div>
    
    <style>
    .typeachat{
        background-color: #17a2b8;
        color: #fff;
        font-weight: bold;
        padding: 5px;
        border-radius: 5px;
    }
    
    .typevente{
        background-color: #dc3545;
        color: #fff;
        font-weight: bold;
        padding: 5px;
        border-radius: 5px;
    }
    
    .border {
        border: 1px solid #094077!important;
        border-style: dashed!important;
        border-width: 2px!important;
        background-color: beige;
    }
    
    </style>
    
</div> <!-- End Content -->

@endsection

@section('script')
<script>
    $('.autre_champs').hide();
    
    
    $('#action_id_select').change(function() {
        console.log("xxxxxx");
    
    console.log($('#action_id_select').val());
        if($('#action_id_select') != "" ){
            $('.autre_champs').fadeIn(1000);
        }
    })
 
 
    $("input[name='type_ordre']").click(function(e) {
        
        if(e.currentTarget.value == "achat"){
            $('#typeachat').addClass('typeachat');
            $('#typevente').removeClass('typevente');
        
        }else{
            $('#typevente').addClass('typevente');
        
            $('#typeachat').removeClass('typeachat');
        
        }     
    })
    
    function getOrdre(ordre_id){
    
        $.get("/get-ordre/"+ordre_id, function( data ) {
             
            $('#nom_action').html(data.action.nom+" N°"+data.numero);
            $('#valeur_achat').html("Valeur d'achat: "+ data.valeur_action+" €");
            $('#ordre_id').val( data.id);           
        });
    
    }
    
    function getOrdreVendu(ordre_id){
    
        $.get("/get-ordre/"+ordre_id, function( data ) {
         
            $('#nom_action_modifier1').html(data.action.nom+" N°"+data.numero);
            $('#valeur_action_modifier1').val(data.valeur_action);
            $('#frais_modifier1').val(data.frais_vente);
            $('#date_modifier1').val(data.date_vente);
            $('#ordre_id_modifier1').val( data.id);
         
        });
    
    }
    
    function getOrdreAchete(ordre_id){
    
        $.get("/get-ordre/"+ordre_id, function( data ) {
         
            $('#nom_action_modifier').html(data.action.nom+" N°"+data.numero);
            $('#valeur_action_modifier').val(data.valeur_action);
            $('#date_validite_modifier').val(data.date_validite.substr(0,10) );
            $('#frais_achat_modifier').val(data.frais_achat);
            $('#quantite_modifier').val(data.quantite);
            $('#paiement_modifier').append($('<option>', {
                value: data.paiement,
                text: data.paiement
            }));
            $('#ordre_id_modifier').val( data.id);
           
        });
    
    }
    
 </script>
 

<script src="{{asset('assets/js/vendor/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('assets/js/vendor/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/responsive.bootstrap5.min.js')}}"></script>
<script>
    $(document).ready(function()
    {
        "use strict";
        $("#action-achete-datatable").
            DataTable(
            {
            language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",
            next:"<i class='mdi mdi-chevron-right'>"},
            info:"Showing actions _START_ to _END_ of _TOTAL_",
            lengthMenu:'Afficher <select class=\'form-select form-select-sm ms-1 me-1\'><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> '},
            pageLength:100,
   
            select:{style:"multi"},
            drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded"),
            document.querySelector(".dataTables_wrapper .row").querySelectorAll(".col-md-6").forEach(function(e){e.classList.add("col-sm-6"),e.classList.remove("col-sm-12"),e.classList.remove("col-md-6")})}})});
</script>

<script>
    $(document).ready(function()
    {
        "use strict";
        $("#action-vendu-datatable").
            DataTable(
            {
            language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",
            next:"<i class='mdi mdi-chevron-right'>"},
            info:"Affichage actions _START_ to _END_ of _TOTAL_",
            lengthMenu:'Afficher <select class=\'form-select form-select-sm ms-1 me-1\'><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> '},
            pageLength:100,
   
            select:{style:"multi"},
            drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded"),
            document.querySelector(".dataTables_wrapper .row").querySelectorAll(".col-md-6").forEach(function(e){e.classList.add("col-sm-6"),e.classList.remove("col-sm-12"),e.classList.remove("col-md-6")})}})});
</script>
    
    
@endsection