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
                        
                    <form action="{{route('alerte.index')}}" method="GET">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <label for="date_deb">Groupe de Titres</label>
                                <select name="groupe_id" id="groupe_id" class="form-select">
                                    @if(isset($_GET['groupe_id']) && $_GET['groupe_id'] != "")
                                        <option value="{{ $_GET['groupe_id']}}">xxxxx</option>
                                    @endif
                                    <option value="">Tous</option>
                                    
                                
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <label for="date_deb"> Titres</label>
                                <select name="action_id" id="action_id" class="form-select">
                                    @if(isset($_GET['action_id']) && $_GET['action_id'] != "")
                                        <option value="{{ $_GET['action_id']}}">xxxxx</option>
                                    @endif
                                    <option value="">Tous</option>
                                    
                           
                                </select>
                            </div>
                            
        
                            
                            <div class="col-sm-6 col-md-3">
                                <label for="date_deb"> Date de début</label>
                              <input type="date" class="form-control" id="date_deb"  max="{{date("Y-m-d")}}" @if(isset($_GET['date_deb'])) value="{{$_GET['date_deb']}}" @endif name="date_deb" placeholder="Date début">
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <label for="date_fin"> Date de fin</label>
                                <input type="date" class="form-control" id="date_fin"  max="{{date("Y-m-d")}}" @if(isset($_GET['date_fin'])) value="{{$_GET['date_fin']}}" @endif name="date_fin" placeholder="Date fin">
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
                        <h4 class="header-title mb-3">Alertes</h4> 
               
                        <span class="text-muted fw-bold"> Tous les titres  </span>
                        
                    </div>
                    <div class="col-4">
                
                    <div class="col-4">
                        <p class="text-muted fw-bold text-primary " style="font-size:20px"  >
                          {{-- <span class="clignote"> Portefeuille</span>   : <span class="  text-primary">100 €</span>  --}}
                        </p>
                    </div>
                    
                </div>
                <div class="row"></div>
                    

                    <div class="tab-content">
                        <div class="tab-pane show active" id="bordered-tabs-preview">

                            <div class="row">

                                <div class="col-xxl-12">
                                    <div class="card">
                                        <div class="card-body">
                                      
                            
                                            <div class="table-responsive">
                                            <table class="table table-centered w-100 dt-responsivexxx " id="action-achete-datatable" style="width:100%">
                                                    <thead class="table-lightx" style="background-color: #818b28; color:#fff;">
                                                        <tr>
                                                            <th scope="col">Date</th>
                                                            <th scope="col">Heure alerte </th>
                                                            <th scope="col">Titre </th>
                                                            <th scope="col">Type alerte</th>
                                                            <th scope="col">Gain estimé (€)</th>
                                                            <th scope="col">Action</th>                                                                                                                 
                                                        </tr>
                                                    </thead>
                                                    
                                                  
                                                    
                                                    <tbody>
                                          
                                                    
                                                    @foreach ($alertes as $alerte)
                                                                                                            
                                                        <tr @if($alerte->est_ouvert == false) style="background-color:#eeeeef" @endif>
                                                           
                                                            <td>
                                                                <div  class="d-flex align-items-center" >
                                                                    <div class="flex-grow-1 ms-2">{{$alerte->created_at->format('d/m/Y')}}</div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-grow-1 ms-2 text-danger">{{$alerte->created_at->format('H:i')}} </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-grow-1 ms-2 fw-bold " style="font-size: 16px">{{$alerte->action->nom}}</div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-grow-1 ms-2 fw-bold"><span class="text-danger">{{$alerte->type_ordre}}</span></div>
                                                                </div> 
                                                            </td>
                                                             <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-grow-1 ms-2 fw-bold"><span class="text-primary">{{$alerte->estimation_gain_net}}</span></div>
                                                                </div> 
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a href="{{route('alerte.show', Crypt::encrypt($alerte->id))}}" class="text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Détail"><i class="mdi mdi-eye-outline"></i></a>
                                                                </div> 
                                                            </td>
                                                            
                                                            
                                                        </tr> <!-- end tr -->
                                                        
                                                      
                                                    @endforeach
                            
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->

                            </div> <!-- End row -->
                                                                     
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