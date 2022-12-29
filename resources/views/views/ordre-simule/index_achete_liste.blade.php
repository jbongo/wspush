@extends('layouts.app')
@section('css')
    <link href="{{asset('assets/css/vendor/dataTables.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/vendor/responsive.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/fixedheader/3.3.1/css/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card widget-inline">
                <div class="card-body p-0 my-2 mx-2 fw-bold">
                    <div class="row g-0">
                        
                    <form action="{{route('ordre_simule.index_achete', $algo)}}" method="GET">
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
                            
                            @php 
                                if($algo == 2){
                                    $date_min = "2022-12-02";
                                }
                                elseif($algo == 3){
                                    $date_min = "2022-12-05";
                                }                                   
                                elseif($algo == 4){
                                    $date_min = "2022-12-06";
                                }                                    
                                else{
                                    $date_min = "2022-11-14";
                                }
                   
                            
                            @endphp
                            
                            <div class="col-sm-6 col-md-3">
                                <label for="date_deb"> Date de début</label>
                              <input type="date" class="form-control" id="date_deb" min={{$date_min}} max="{{date("Y-m-d")}}" @if(isset($_GET['date_deb'])) value="{{$_GET['date_deb']}}" @endif name="date_deb" placeholder="Date début">
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <label for="date_fin"> Date de fin</label>
                                <input type="date" class="form-control" id="date_fin" min={{$date_min}} max="{{date("Y-m-d")}}" @if(isset($_GET['date_fin'])) value="{{$_GET['date_fin']}}" @endif name="date_fin" placeholder="Date fin">
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
                        <h5 class="header-title mb-3 text-info">
                        @if($algo == 2)
                            Algo 2 - Ne plus acheter après <span class="text-danger fw-bold"> {{$parametre->heure_delais_achat}}</span>
                        @elseif($algo == 3)
                            Algo 3 - après la 1ère journée, Il faut vendre si la valeur d'achat + frais est positif
                        @elseif($algo == 4)
                            Algo 4 - Il faut acheter à <span class="text-danger fw-bold"> {{$parametre->heure_fixe_achat}}</span> et revendre à <span class="text-danger fw-bold"> {{$parametre->heure_fixe_vente}}</span>
                        @else
                            Algo 1 - Par défaut
                        @endif</h5> 
                        <span class="text-muted fw-bold">@if($action_select != null ) {{$action_select->nom}} @else Tous les titres @endif  </span>
                        <span class="text-danger fw-bold"> @if($nb_jours_select > 0 ) Sur {{$nb_jours_select}} jours @else @if(isset($_GET['date_deb']) && $_GET['date_deb']!= "") pour la journée du {{string_to_date($_GET['date_deb'])}} @else Aujourd'hui @endif @endif</span>
                        
                    </div>
                    <div class="col-4">
                    {{-- {{dd($algo)}} --}}
                        <p class="text-muted text-primary "  >
                            <a @if($algo != null) href="{{route('ordre_simule.index_achete',[$algo, 'grid'])}}" @else  href="{{route('ordre_simule.index_achete','grid')}} "  @endif style="text-decoration: underline; font-size: 15px; ">Changer l'affichage: <i style="font-size: 25px; " class="mdi  mdi-view-grid "></i>  </a> 
                        </p>
                    </div>
                    <div class="col-4">
                        <p class="text-muted fw-bold text-primary " style="font-size:20px"  >
                          <span class="clignote"> Portefeuille</span>   : <span class="  text-primary">{{round($portefeuille,3)}} €</span> 
                        </p>
                    </div>
                    <div class="col-4">
                        <p class="text-muted fw-bold text-primary " style="font-size:20px"  >
                          <span class="clignote"> Gains</span>   : <span class="  @if($gains >= 0) text-success @else text-danger @endif">{{round($gains,3)}} €</span> 
                        </p>
                    </div>
                </div>
                <div class="row"></div>
                    

                    <div class="tab-content">
                        <div class="tab-pane show active" id="bordered-tabs-preview">
                            <ul class="nav nav-tabs nav-bordered mb-3">
                                <li class="nav-item">
                                    <a href="#home-b1" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                        <span class="d-none d-md-block">Achetés</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    {{-- <a href="{{route('ordre_simule.index_vendu', $algo)}}"  aria-expanded="true" class="nav-link ">
                                        <span class="d-none d-md-block">Vendus</span>
                                    </a> --}}
                                    <a href="{{str_replace('achete','vendu',$_SERVER['REQUEST_URI'])}}"  aria-expanded="true" class="nav-link ">
                                        <span class="d-none d-md-block">Vendus</span>
                                    </a>
                                   
                                </li>
                               
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane show active" id="home-b1">
                                    
                                    <div class="row">
        
                                        <div class="col-xxl-12">
                                            <div class="card">
                                                <div class="card-body">
                                              
                                    
                                                    <div class="table-responsive">
                                                    <table class="table table-centered w-100 dt-responsivexxx " id="action-achete-datatable" style="width:100%">
                                                            <thead class="table-lightx" style="background-color: #17a2b8; color:#fff;">
                                                                <tr>
                                                                    <th scope="col">Date</th>
                                                                    <th scope="col">Heure achat </th>
                                                                    <th scope="col">Titre </th>
                                                                    <th scope="col">Val actuelle (€)</th>
                                                                    <th scope="col">Val d'achat (€)</th>
                                                                    <th scope="col">Vendre à  (€)</th>
                                                                    <th scope="col">Qté </th>
                                                                    {{-- <th scope="col">Date de validité</th> --}}
                                                                    <th scope="col">Frais (€)</th>
                                                                </tr>
                                                            </thead>
                                                            
                                                          
                                                            
                                                            <tbody>
                                                            
                                                            @foreach ($ordres_achetes as $ordre)
                                                                @if($ordre)
                                                            
                                                                <tr>
                                                                   
                                                                    <td>
                                                                        <div @if(date('Y-m-d')!= $ordre->created_at->format('Y-m-d'))  style="background-color:#f62a2a; color:#fff"  class="clignote d-flex align-items-center" @endif class="d-flex align-items-center" >
                                                                            <div class="flex-grow-1 ms-2">{{$ordre->created_at->format('d/m/Y')}}</div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-grow-1 ms-2 text-danger">{{$ordre->created_at->format('H:i')}} </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-grow-1 ms-2 fw-bold " style="font-size: 16px">{{$ordre->action->nom}} N°{{$ordre->numero}}</div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-grow-1 ms-2 fw-bold"><span class="text-danger">{{$ordre->action->valeuraction()->valeur}}</span></div>
                                                                        </div> 
                                                                    </td>
                                                                     <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-grow-1 ms-2 fw-bold"><span class="text-primary">{{$ordre->valeur_action}}</span></div>
                                                                        </div> 
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-grow-1 ms-2 fw-bold"><span class="text-success"  style="font-size:20px">{{$ordre->valeurVente()}}</span></div>
                                                                        </div> 
                                                                    </td>
                                                                    <td>
                                                                        <span class="text-default">{{$ordre->quantite}}  </span> 
                                                                    </td>
                                                                    {{-- <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-grow-1 ms-2">{{$ordre->date_validite}}  </div>
                                                                        </div>
                                                                    </td> --}}
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-grow-1 ms-2">{{$ordre->frais_achat}}  </div>
                                                                        </div>
                                                                    </td>
                                                                 
                                                                    
                                                                    
                                                                </tr> <!-- end tr -->
                                                                
                                                                @endif
                                                            @endforeach
                                    
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->

                                    </div> <!-- End row -->
                                </div>
                                <div class="tab-pane " id="profile-b1">
                                                              
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
    
    .clignote  {
       animation-duration: 2.0s;
       animation-name: clignoter;
       animation-iteration-count: infinite;
       transition: none;
    }
    @keyframes clignoter {
      0%   { opacity:1; }
      40%   {opacity:0; }
      100% { opacity:1; }
    }
    
    </style>
    
</div> <!-- End Content -->

@endsection

@section('script')
<script>
    $('.autre_champs').hide();
    
    
    
    $('#action_id').change(function() {
    
    console.log($('#action_id').val());
        if($('#action_id') != "" ){
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
<script src="https://cdn.datatables.net/fixedheader/3.3.1/js/dataTables.fixedHeader.min.js"></script>

<script>
    $(document).ready(function()
    {
        "use strict";
        $("#action-achete-datatable").
            DataTable(
            {
                fixedHeader: true,
                language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",
                next:"<i class='mdi mdi-chevron-right'>"},
                info:"Affichage actions _START_ to _END_ of _TOTAL_",
                lengthMenu:'Afficher <select class=\'form-select form-select-sm ms-1 me-1\'><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> '},
                pageLength:100,
       
                select:{style:"multi"},
                drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded"),
                document.querySelector(".dataTables_wrapper .row").querySelectorAll(".col-md-6").forEach(function(e){e.classList.add("col-sm-6"),e.classList.remove("col-sm-12"),e.classList.remove("col-md-6")})}
            })
    });
</script>

<script>
    $(document).ready(function()
    {
        "use strict";
        $("#action-vendu-datatable").
            DataTable(
            {
                fixedHeader: true,
                language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",
                next:"<i class='mdi mdi-chevron-right'>"},
                info:"Affichage actions _START_ to _END_ of _TOTAL_",
                lengthMenu:'Afficher <select class=\'form-select form-select-sm ms-1 me-1\'><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> '},
                pageLength:100,
       
                select:{style:"multi"},
                drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded"),
                document.querySelector(".dataTables_wrapper .row").querySelectorAll(".col-md-6").forEach(function(e){e.classList.add("col-sm-6"),e.classList.remove("col-sm-12"),e.classList.remove("col-md-6")})}
            })
    });
</script>
    
    
@endsection