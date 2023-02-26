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
                        <li class="breadcrumb-item active">Sites internes</li>
                    </ol>
                </div>
                <h4 class="page-title">Sites internes</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        
                        <div class="col-sm-2 mr-14 ">
                            <a href="{{route('article.add')}}" type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="uil-plus"></i> Ajouter</a>
                        </div>
                        @if(session('ok'))
                        <div class="col-6">
                            <div class="alert alert-success alert-dismissible bg-success text-white text-center border-0 fade show" role="alert">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong> {{session('ok')}}</strong>
                            </div>
                        </div>
                        @endif

                        @if(session('nok'))
                        <div class="col-6">
                            <div class="alert alert-success alert-dismissible bg-danger text-white text-center border-0 fade show" role="alert">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong> {{session('ok')}}</strong>
                            </div>
                        </div>
                        @endif

                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-box-->
        </div> <!-- end col-->
    </div>

    <div class="row">
        
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-body">
              
    
                    <div class="table-responsive">
                    <table class="table table-centered w-100 dt-responsive nowrap" id="action-achete-datatable">
                            <thead class="table-lightx" style="background-color: #17a2b8; color:#fff;">
                                <tr>
                                    <th scope="col">Pays</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Url</th>
                                    <th scope="col">Catégories</th>
                                    <th scope="col">Statut</th>                                    
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            
                          
                            
                            <tbody>
                            
                            @foreach ($sites as $site)
                                                           
                                <tr>
                                   
                        
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 ms-2 fw-bold " style="font-size: 16px">{{$site->pays}}</div>
                                            
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">                                            
                                            <p class="mb-0 text-muted">{{$site->nom}}</p>
                                        </div> 
                                    </td>
                                     <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 ms-2 fw-bold"><span class="text-danger">{{$site->url}}</span></div>
                                        </div> 
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                                                                   
                                            <p class="inbox-item-date">
                                                <a  href="{{route('categorie_interne.index',Crypt::encrypt($site->id))}}" type="button" class="btn btn-sm btn-success px-1 py-0">
                                                     <i class='uil uil-eye font-14'></i> </a>
                                            </p>
                                            <p class="inbox-item-date" style="margin-left: 5px" >
                                                <button href="{{route('categorie_interne.add',$site->id)}}"  type="button" class="btn btn-sm btn-primary px-1 py-0 add_categorie"
                                                    data-site_id="{{$site->id}}" data-nom="{{$site->nom}}"  data-bs-toggle="modal" data-bs-target="#editCategorieModal"   >
                                                     <i data-bs-toggle="tooltip" data-bs-placement="top" title="Ajouter une nouvelle catégorie" class='uil uil-plus font-14'></i> </button>
                                            </p>
                                        </div> 
                                    </td>                                
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <h5 class="text-danger my-0">@if($site->est_actif == true)  Actif @else Désactivé @endif </h5>
                                        </div>
                                    </td>
                                    <td>
                                        <a  class="text-success modifier" data-bs-toggle="modal" data-bs-target="#editModal"
                                            
                                            data-nom="{{$site->nom}}" data-url="{{$site->url}}" data-pays="{{$site->pays}}" data-login="{{$site->login}}" data-passwordx="{{$site->password}}"
                                            data-href="{{route('site_interne.update', Crypt::encrypt($site->id))}}" data-site_id="{{$site->id}}" 
                                            title="Modifier" ><i class="mdi mdi-lead-pencil"></i></a>
                                            {{-- 
                                            <a href="{{route('article.show', Crypt::encrypt($site->id))}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Détail"><i class="mdi mdi-eye-outline"></i></a>
                                            <a href="{{route('article.archiver', Crypt::encrypt($site->id))}}" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Dupliquer l'action"><i class="mdi mdi-content-duplicate"></i></a> --}}
                                
                                    </td>

                                </tr> <!-- end tr -->

                            @endforeach
    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->

        
        <!-- Modal Add Site -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addActionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{route('site_interne.store')}}" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addActionModalLabel">Ajouter un site interne</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            
                                @csrf

                                <div class="row autre_champs" style="margin-top: 20px">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="nom" class="form-label">Nom du site *</label>
                                            <input type="text"  class="form-control" name="nom" id="nom"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="url" class="form-label">Url du site *</label>
                                            <input type="url" class="form-control" name="url" id="url"  required >
                                        </div>      
                                    </div>
                                </div>

                                <div class="row autre_champs" style="margin-top: 20px">
                                    <div class="col-6" >
                                        <div id="" class="custom-control custom-radio custom-control-inline">
                                            <label class="custom-control-label" for="pays">Pays *</label>
                                            <select name="pays" class="form-control" id="pays" required>                                                
                                                <option value="Côte d'Ivoire">Côte d'Ivoire</option> 
                                                <option value="Gabon">Gabon</option>                                              
                                                <option value="Bénin">Bénin</option>                                              
                                            </select>
                                        </div>                                        
                                    </div> 
                                </div>

                                <div class="row autre_champs" style="margin-top: 20px">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="login" class="form-label">Login</label>
                                            <input type="text"  class="form-control" name="login" id="login"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Mot de passe </label>
                                            <input type="text"  class="form-control" name="password" id="password"  required>
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


        <!-- Modal Edit Site -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="" id="form-edit" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Modifier </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                            @csrf

                            <div class="row autre_champs" style="margin-top: 20px">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="edit_nom" class="form-label">Nom du site *</label>
                                        <input type="text"  class="form-control" name="nom" id="edit_nom"  required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="edit_url" class="form-label">Url du site *</label>
                                        <input type="url" class="form-control" name="url" id="edit_url"  required >
                                    </div>      
                                </div>
                            </div>

                            <div class="row autre_champs" style="margin-top: 20px">
                                <div class="col-6" >
                                    <div id="" class="custom-control custom-radio custom-control-inline">
                                        <label class="custom-control-label" for="edit_pays">Pays *</label>
                                        <select name="pays" class="form-control" id="edit_pays" required>                                                
                                            <option value="Côte d'Ivoire">Côte d'Ivoire</option> 
                                            <option value="Gabon">Gabon</option>                                              
                                            <option value="Bénin">Bénin</option>                                              
                                        </select>
                                    </div>                                        
                                </div> 
                            </div>

                            <div class="row autre_champs" style="margin-top: 20px">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="edit_login" class="form-label">Login</label>
                                        <input type="text"  class="form-control" name="login" id="edit_login"  required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="edit_password" class="form-label">Mot de passe </label>
                                        <input type="text"  class="form-control" name="password" id="edit_password"  required>
                                    </div>
                                </div>
                            </div>
                            
                                                                
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">Modifier</button>
                    </div>
                </div>
            </form> 
        </div>
    </div>
    
    </div> <!-- End row -->


     <!-- Modal Add categorie -->
     <div class="modal fade" id="editCategorieModal" tabindex="-1" aria-labelledby="addActionModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form action="{{route('categorie_interne.store')}}" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addActionModalLabel">Ajouter une catégorie à <span id="nom_site"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                            @csrf

                            <div class="row autre_champs" style="margin-top: 20px">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="nom_categorie" class="form-label">Nom de la catégorie *</label>
                                        <input type="text"  class="form-control" name="nom" id="nom_categorie"  required>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" name="siteinterne_id" id="siteinterne_id"  required >

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


{{-- Modification d'une tâche --}}
<script>
    $('.modifier').on( 'click',function (e) {

        let that = $(this);
        $('#edit_nom').val(that.data('nom')) ;
        $('#edit_url').val(that.data('url')) ;

        $('#edit_pays').val(that.data('pays')) ;
        
        $('#edit_login').val(that.data('login')) ;
        $('#edit_password').val(that.data('passwordx')) ;

        let pays = that.data('pays');

        $('#edit_pays option[value='+pays+']').attr('selected','selected');
        
        let currentFormAction = that.data('href');
        $('#form-edit').attr('action', currentFormAction) ;

    });

</script>

{{-- Ajout d'une catégorie--}}
<script>
    $('.add_categorie').on( 'click',function (e) {

        let that = $(this);
        $('#nom_site').text(that.data('nom')) ;
        $('#siteinterne_id').val(that.data('site_id')) ;

        // console.log(that.data('site_id'));
        
        // let currentFormAction = that.data('href');
        // $('#form-edit-categorie').attr('action', currentFormAction) ;

    });

</script>
        

<script>
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