@extends('layouts.app')
@section('css')
    <link href="{{asset('assets/css/vendor/dataTables.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/vendor/responsive.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="content">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Titres</li>
                    </ol>
                </div>
                <h4 class="page-title">Tous les Titres</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 
    
    <div class="row">
    <div class="card">
        <div class="card-body" style="padding: 0.5rem 0.5rem">
            <div class="col-12">
                <div class="row">    
                    <div class="col-sm-6 col-xl-3">
                        <div class="card mb-0 ">
                            <div class="card-body" >
                                <div class="border-dashed border-2 border border-action h-100 w-100 rounded d-flex align-items-center justify-content-center">
                                    <a href="javascript:void(0);" class="text-center text-muted p-2" data-bs-toggle="modal" data-bs-target="#addActionModal">
                                        <i class="mdi mdi-plus h3 my-0"></i> <h4 class="font-16 mt-1 mb-0 d-block text-primary">Nouveau Titre</h4>
                                    </a>
                                </div>
                            </div> 
                        </div> 
                    </div> 
                    @if(session('ok'))
                        <div class="col-6">
                            <div class="alert alert-success alert-dismissible bg-success text-white text-center border-0 fade show" role="alert">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong> {{session('ok')}}</strong>
                            </div>
                        </div>
                    @endif
                    @if($errors->all())
                        <div class="col-6">
                            @foreach ($errors->all() as $error)
                                <span class="text-danger fw-bold"><li> {{$error}}</li> </span>
                            @endforeach
                        </div>
                    @endif
                        
                </div> <!-- end row -->
                <div class="row">
                    <div class="col-6">
                        <p class="text-muted  text-primary "  >
                            <a href="{{route('action.index','grid')}} " style="text-decoration: underline; font-size: 15px; ">Changer l'affichage: <i style="font-size: 25px; " class="mdi mdi-view-grid "></i>  </a> 
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
       

    </div>



    <div class="row">
        
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-body">
              
    
                    <div class="table-responsive">
                    <table class="table table-centered w-100 dt-responsive nowrap" id="action-achete-datatable">
                            <thead class="table-lightx" style="background-color: #17a2b8; color:#fff;">
                                <tr>
                                    <th scope="col">Titre</th>
                                    <th scope="col">Valeur actuelle (€)</th>
                                    <th scope="col">Pourcentage % </th>
                                    <th scope="col">Seuil Haut</th>
                                    <th scope="col">Seuil Bas </th>
                                    <th scope="col">SMS</th>
                                    <th scope="col">Simulation</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            
                          
                            
                            <tbody>
                            
                            @foreach ($actions as $action)
                                @if($action)
                            
                                <tr>
                                   
                        
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 ms-2 fw-bold " style="font-size: 16px">{{$action->nom}}</div>
                                            
                                        </div>
                                    </td>
                                     <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 ms-2 fw-bold"><span class="text-danger">{{$action->valeuraction()->valeur}}</span></div>
                                        </div> 
                                    </td>
                                     <td>
                                        <div class="d-flex align-items-center">                                            
                                            <p class="mb-0 text-muted">@if($action->valeuraction()->pourcentage >= 0) <i class="mdi mdi-arrow-up-bold text-success"></i> @else <i class="mdi mdi-arrow-down-bold text-danger"></i>    @endif {{$action->valeuraction()->pourcentage}}% </p>
                                        </div> 
                                    </td>
                                    <td>
                                        <span class="text-default"><h5 class="text-success my-0">{{$action->valeuraction()->valeur_haute }} </h5> </span> 
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <h5 class="text-danger my-0">{{$action->valeuraction()->valeur_basse }} </h5>
                                        </div>
                                    </td>
                                    <td>
                                        @if($action->parametreAction != null)
                                            @if($action->est_actif == false)                                      
                                                <div class="col-6">
                                                    <a href="javascript:void(0);" data-href="{{route('action.activer', $action->id)}}" class="btn btn-danger activer_sms"   data-bs-toggle="tooltip" data-bs-placement="top" title="Activer"> SMS</a>
                                                </div>
                                            @else 
                                                <div class="col-6">
                                                    <a href="javascript:void(0);" data-href="{{route('action.desactiver', $action->id)}}" class="btn btn-primary  desactiver_sms"   data-bs-toggle="tooltip" data-bs-placement="top" title="Désactiver"> SMS</a>
                                                </div>                                        
                                            @endif 

                                        @else 
                                            @if($action->est_actif == false)                                      
                                                <div class="col-6">
                                                    <a href="javascript:void(0);" class="btn btn-secondary" style="cursor: not-allowed;"   data-bs-toggle="tooltip" data-bs-placement="top" title="Il faut d'abord paramétrer l'action"> SMS</a>
                                                </div>                                           
                                            @endif 
                                        
                                        @endif
                                    </td>
                                    <td>
                                        @if($action->parametreAction != null)
                                        
                                            
                                            @if($action->est_actif_simulation == false)                                        
                                                <div class="col-6">
                                                    <a href="javascript:void(0);" data-href="{{route('action.activer', [$action->id, "simule"])}}" class="btn btn-danger activer_simulation"   data-bs-toggle="tooltip" data-bs-placement="top" title="Activer"> simulation</a>
                                                </div>
                                            @else 
                                                <div class="col-6">
                                                    <a href="javascript:void(0);" data-href="{{route('action.desactiver',[ $action->id, "simule"])}}" class="btn btn-primary  desactiver_simulation"   data-bs-toggle="tooltip" data-bs-placement="top" title="Désactiver"> simulation</a>
                                                </div>                                            
                                            @endif
                                        @else 
                                            
                                            @if($action->est_actif_simulation == false)                                        
                                                <div class="col-6">
                                                    <a href="javascript:void(0);" class="btn btn-secondary " style="cursor: not-allowed;"   data-bs-toggle="tooltip" data-bs-placement="top" title="Il faut d'abord paramétrer l'action"> simulation</a>
                                                </div>                                           
                                            @endif
                                        
                                        @endif
                                    </td>
                                    <td>
                                        @if($action->parametreAction == null)
                                            <div class="col-4" style="">
                                                <a href="{{route('action.edit', Crypt::encrypt($action->id))}}" class="btn btn-danger " data-bs-toggle="tooltip" data-bs-placement="top" title="Ajouter les paliers"> Paramètres</a>
                                            </div>                                        
                                        @else                                       
                                            <a href="{{route('action.edit', Crypt::encrypt($action->id))}}" class="text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier"><i class="mdi mdi-square-edit-outline"></i></a>

                                            <a href="{{route('action.show', Crypt::encrypt($action->id))}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Détail"><i class="mdi mdi-eye-outline"></i></a>
                                            <a href="{{route('action.dupliquer', Crypt::encrypt($action->id))}}" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Dupliquer l'action"><i class="mdi mdi-content-duplicate"></i></a>

                                        @endif
                                
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

        
         <!-- Modal -->
         <div class="modal fade" id="addActionModal" tabindex="-1" aria-labelledby="addActionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{route('action.store')}}" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addActionModalLabel">Ajouter une action</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            
                                @csrf
                                <div class="mb-3">
                                    <label for="nom" class="form-label">Nom</label>
                                    <input type="text" class="form-control" name="nom" id="nom"  required>
                                </div>
                                <div class="mb-3">
                                    <label for="url" class="form-label">Url</label>
                                    <input type="url" class="form-control" name="url" id="url" required >
                                </div>      
                                                                    
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </div>
                </form> 
            </div>
        </div>

      
    </div> <!-- End row -->



    
</div> <!-- End Content -->
<style>
    .border-action {
        border: 1px solid #094077!important;
        border-style: dashed!important;
        border-width: 2px!important;
        background-color: beige;
    }

</style>


@endsection

@section('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
 
 
//  Activation de SMS
 $(".activer_sms").click(function(){
 
    let that = $(this);
    
    Swal.fire({
        title: 'Vraiment Activer ?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui',
        cancelButtonText: 'Non',
    }).then((result) => {
        if (result.isConfirmed) {
            
            $.ajax({
                type: "GET",
               
                url: that.attr('data-href'),
               
                // data: data,
                success: function(data) {
                    console.log(data);
                    
                    Swal.fire(
                      'SMS Activé!',
                      '',
                      'success'
                    )
                    .then(function() {
                        location.reload(true)
                    })
                },
                error: function(data) {
                    console.log(data);
                    
                    swal(
                        'Echec',
                        'Le SMS n\'a pas été activé :)',
                        'error'
                    );
                }
            });
           
        }else{
        
            Swal.fire(
              'Annulé!',
              '',
              'error'
            )
        }
    })
 
 });
 
 
 
//  Désactivation de SMS

$(".desactiver_sms").click(function(){
 
 let that = $(this);
 
 Swal.fire({
     title: 'Vraiment Désactiver ?',
     text: "",
     icon: 'warning',
     showCancelButton: true,
     confirmButtonColor: '#3085d6',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Oui',
     cancelButtonText: 'Non',
 }).then((result) => {
    if (result.isConfirmed) {
         
         $.ajax({
             type: "GET",
            
             url: that.attr('data-href'),
            
             // data: data,
             success: function(data) {
                 console.log(data);
                 
                 Swal.fire(
                   'SMS désactivé!',
                   '',
                   'success'
                 )
                 .then(function() {
                     location.reload(true)
                 })
             },
             error: function(data) {
                 console.log(data);
                 
                 swal(
                     'Echec',
                     'Le SMS n\'a pas été désactivé :)',
                     'error'
                 );
             }
         });
        
     }else{
     
         Swal.fire(
           'Annulé!',
           '',
           'error'
         )
     }
 })

});
 
 
 
//  Activation de simulation 
 

$(".activer_simulation").click(function(){
 
 let that = $(this);
 
 Swal.fire({
     title: 'Vraiment Activer ?',
     text: "",
     icon: 'warning',
     showCancelButton: true,
     confirmButtonColor: '#3085d6',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Oui',
     cancelButtonText: 'Non',
 }).then((result) => {
     if (result.isConfirmed) {
         
         $.ajax({
             type: "GET",
            
             url: that.attr('data-href'),
            
             // data: data,
             success: function(data) {
                 console.log(data);
                 
                 Swal.fire(
                   'Simulation Activée!',
                   '',
                   'success'
                 )
                 .then(function() {
                     location.reload(true)
                 })
             },
             error: function(data) {
                 console.log(data);
                 
                 swal(
                     'Echec',
                     'La simulation n\'a pas été activée :)',
                     'error'
                 );
             }
         });
        
     }else{
     
         Swal.fire(
           'Annulé!',
           '',
           'error'
         )
     }
 })

});



//  Désactivation de simulation

$(".desactiver_simulation").click(function(){

let that = $(this);

Swal.fire({
  title: 'Vraiment Désactiver ?',
  text: "",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Oui',
  cancelButtonText: 'Non',
}).then((result) => {
 if (result.isConfirmed) {
      
      $.ajax({
          type: "GET",
         
          url: that.attr('data-href'),
         
          // data: data,
          success: function(data) {
              console.log(data);
              
              Swal.fire(
                'Simulation désactivée!',
                '',
                'success'
              )
              .then(function() {
                  location.reload(true)
              })
          },
          error: function(data) {
              console.log(data);
              
              swal(
                  'Echec',
                  'La simulation n\'a pas été désactivée :)',
                  'error'
              );
          }
      });
     
  }else{
  
      Swal.fire(
        'Annulé!',
        '',
        'error'
      )
  }
})

});
 
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
@endsection