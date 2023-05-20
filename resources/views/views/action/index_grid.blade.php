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
        <div class="card-body">
            <div class="col-12">
                <div class="row">    
                    <div class="col-sm-6 col-xl-3">
                        <div class="card mb-0 h-100">
                            <div class="card-body" style="padding: 0.7rem 0.8rem">
                                <div class="border-dashed border-2 border border-action h-100 w-100 rounded d-flex align-items-center justify-content-center">
                                    <a href="javascript:void(0);" class="text-center text-muted p-2" data-bs-toggle="modal" data-bs-target="#addActionModal">
                                        <i class="mdi mdi-plus h3 my-0"></i> <h4 class="font-16 mt-1 mb-0 d-block text-primary">Nouveau titre</h4>
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
                            <a href="{{route('action.index')}} " style="text-decoration: underline; font-size: 15px; ">Changer l'affichage: <i style="font-size: 25px; " class="mdi mdi-format-list-bulleted-square"></i>  </a> 
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
       

    </div>



    <div class="row">
        
        @foreach ($actions as $action)
            @if($action->valeuraction())
                <div class=" col-sm-6 col-md-6 col-lg-6  col-xl-4  ">
                    <div class="card">
                        <div class="card-body" @if($action->est_actif == false) style="background-color: #e7e8e7;" @endif>
                            <div class="dropdown float-end">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a href="{{route('action.show', Crypt::encrypt($action->id))}}" class="dropdown-item">Détails</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Archiver</a>
                                </div>
                            </div>
        
                            <div class="text-center">
                                <img src="{{asset('assets/images/logo-action.png')}}" class="rounded-circle avatar-md img-thumbnail" alt="friend">
                                <h4 class="mt-3 my-1">{{$action->nom}} @if($action->valeuraction()->pourcentage >= 0)  <i class="mdi mdi-arrow-top-right-thin text-success"></i>  @else <i class="mdi mdi-arrow-bottom-left-thin text-danger"></i> @endif </h4>
                                <p class="mb-0 text-muted mt-2">
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="mt-0 mb-1 font-20">{{$action->valeuraction()->valeur}} EUR</h4>
                                        <p class="mb-0 text-muted">@if($action->valeuraction()->pourcentage >= 0) <i class="mdi mdi-arrow-up-bold text-success"></i> @else <i class="mdi mdi-arrow-down-bold text-danger"></i>    @endif {{$action->valeuraction()->pourcentage}}% </p>
                                    </div>
                                </p>
                                <hr class="bg-dark-lighten my-3">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="border border-light p-3 rounded mb-3">                         
                                 
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="font-15 mb-1">Plus Haut</p>
                                                    <h5 class="text-success my-0">{{$action->valeuraction()->valeur_haute }} <br> EUR</h5>
                                                </div>  
                                                <div class="avatar-xs">
                                                    <span class="avatar-title bg-success rounded-circle h3 my-0">
                                                        <i class="mdi mdi-arrow-up-bold-outline"></i>
                                                    </span>
                                                </div>                                      
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border border-light p-3 rounded mb-3">                         
                                 
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="font-15 mb-1">Plus Bas</p>
                                                    <h5 class="text-danger my-0">{{$action->valeuraction()->valeur_basse }} <br> EUR</h5>
                                                </div>  
                                                <div class="avatar-xs">
                                                    <span class="avatar-title bg-danger rounded-circle h3 my-0">
                                                        <i class="mdi mdi-arrow-down-bold-outline"></i>
                                                    </span>
                                                </div>                                      
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                                <div class="row">
                                    @if($action->parametreAction != null)
                                        @if($action->est_actif == false)                                      
                                            <div class="col-6">
                                                <a href="javascript:void(0);" data-href="{{route('action.activer', $action->id)}}" class="btn btn-danger w-100 activer_sms"   data-bs-toggle="tooltip" data-bs-placement="top" title="Activer"> SMS</a>
                                            </div>
                                        @else 
                                            <div class="col-6">
                                                <a href="javascript:void(0);" data-href="{{route('action.desactiver', $action->id)}}" class="btn btn-primary w-100 desactiver_sms"   data-bs-toggle="tooltip" data-bs-placement="top" title="Désactiver"> SMS</a>
                                            </div>                                        
                                        
                                        @endif 
                                        
                                        @if($action->est_actif_simulation == false)                                        
                                            <div class="col-6">
                                                <a href="javascript:void(0);" data-href="{{route('action.activer', [$action->id, "simule"])}}" class="btn btn-danger w-100 activer_simulation"   data-bs-toggle="tooltip" data-bs-placement="top" title="Activer"> simulation</a>
                                            </div>
                                        @else 
                                            <div class="col-6">
                                                <a href="javascript:void(0);" data-href="{{route('action.desactiver',[ $action->id, "simule"])}}" class="btn btn-primary w-100 desactiver_simulation"   data-bs-toggle="tooltip" data-bs-placement="top" title="Désactiver"> simulation</a>
                                            </div>                                            
                                        @endif
                                    @else 
                                        @if($action->est_actif == false)                                      
                                            <div class="col-6">
                                                <a href="javascript:void(0);" class="btn btn-secondary w-100 " style="cursor: not-allowed;"   data-bs-toggle="tooltip" data-bs-placement="top" title="Il faut d'abord paramétrer l'action"> SMS</a>
                                            </div>
                                       
                                        @endif 
                                        
                                        @if($action->est_actif_simulation == false)                                        
                                            <div class="col-6">
                                                <a href="javascript:void(0);" class="btn btn-secondary w-100 " style="cursor: not-allowed;"   data-bs-toggle="tooltip" data-bs-placement="top" title="Il faut d'abord paramétrer l'action"> simulation</a>
                                            </div>                                           
                                        @endif
                                    
                                    @endif
                                </div>
                                
                                
                                
                                
                                <div class="row mt-4" @if($action->parametreAction == null) style="overflow-wrap: normal;display: flex; flex-direction: row; justify-content:center" @else style="overflow-wrap: normal;" @endif >
                                
                                    @if($action->parametreAction == null)
                                        <div class="col-4" style="">
                                            <a href="{{route('action.edit', Crypt::encrypt($action->id))}}" class="btn btn-danger " data-bs-toggle="tooltip" data-bs-placement="top" title="Ajouter les paliers"> Paramètres</a>
                                        </div>                                        
                                    @else                                       
                                        
                                        <div class="col-4">
                                            <a href="{{route('action.edit', Crypt::encrypt($action->id))}}" class="btn w-100 btn-light text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier"><i class="mdi mdi-square-edit-outline"></i></a>
                                        </div>
                                        <div class="col-4">
                                            <a href="{{route('action.show', Crypt::encrypt($action->id))}}" class="btn w-100 btn-light text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Détail"><i class="mdi mdi-eye-outline"></i></a>
                                        </div>
                                        <div class="col-4">
                                            <a href="{{route('action.dupliquer', Crypt::encrypt($action->id))}}" class=" btn w-100 btn-light  text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Dupliquer l'action"><i class="mdi mdi-content-duplicate"></i></a>
                                        </div>
                                        
                                        
                                        
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End col -->
            @endif
        @endforeach

        
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





    <div class="row py-4">
        <div class="col-12 text-center">
            <i class="mdi mdi-dots-circle mdi-spin font-24 text-muted"></i>
        </div>
    </div>
    
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
@endsection