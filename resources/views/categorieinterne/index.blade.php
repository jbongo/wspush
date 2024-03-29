@extends('layouts.app')
@section('css')
    <link href="{{asset('assets/css/vendor/dataTables.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/vendor/responsive.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
@endsection

@section('content')

<div class="content">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Catégories internes</li>
                    </ol>
                </div>
                <h4 class="page-title">Catégories internes de {{$siteinterne->nom}}</h4>
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
                            <a href="{{route('site_interne.index')}}" type="button" class="btn btn-outline-secondary"><i class="uil-arrow-left"></i> Retour</a>
                            @can('permission', 'ajouter-categorie-interne')                                      

                                <a href="{{route('article.add')}}" type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="uil-plus"></i> Ajouter</a>
                            @endcan
                        </div>
                        @if(session('ok'))
                        <div class="col-6">
                            <div class="alert alert-success alert-dismissible bg-success text-white text-center border-0 fade show" role="alert">
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
                                    <th scope="col">Nom</th>
                                    <th scope="col">Url</th>
                                                                 
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            
                          
                            
                            <tbody>
                            
                            @foreach ($categories as $categorie)
                                                           
                                <tr>
                                   
                                   
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 ms-2 fw-bold " style="font-size: 16px">{{$categorie->nom}}</div>
                                            
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">                                            
                                            <p class="mb-0 text-muted">{{$categorie->url}}</p>
                                        </div> 
                                    </td>
                                    
                                    <td>
                                        @can('permission', 'modifier-categorie-interne')                                      

                                        <a  class="text-success modifier" href="{{route('categorie_interne.edit', Crypt::encrypt($categorie->id))}}"
                                            title="Modifier" ><i class="mdi mdi-square-edit-outline"></i></a>
                                        @else 
                                        <a  class="text-secondary" style="cursor: no-drop;" data-bs-toggle="tooltip" data-bs-placement="top" title="Permission non accordée" ><i class="mdi mdi-square-edit-outline"></i></a>

                                        @endcan
                                            {{-- 
                                            <a href="{{route('article.show', Crypt::encrypt($categorie->id))}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Détail"><i class="mdi mdi-eye-outline"></i></a>
                                            <a href="{{route('article.archiver', Crypt::encrypt($categorie->id))}}" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Dupliquer l'action"><i class="mdi mdi-content-duplicate"></i></a> --}}
                                
                                    </td>

                                </tr> <!-- end tr -->

                            @endforeach
    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->

        
        <!-- Modal Add Catégorie -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addActionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{route('categorie_interne.store')}}" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addActionModalLabel">Ajouter une catégorie interne</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            
                                @csrf

                                <div class="row">
                                    <div class="col-7">
                                        <div class="mb-3">
                                            <label for="categorie_cree" class="form-label">La catégorie a t'elle déjà été créée sur le site ?</label>
                                            <select name="categorie_cree" id="categorie_cree" class="form-select">
                                                <option value="non">non</option>
                                                <option value="oui">oui</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden"  class="form-control" name="siteinterne_id" id="siteinterne_id" value="{{$siteinterne->id}}"  required>


                                <div class="row " style="margin-top: 20px">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nom_categorie" class="form-label">Nom de la catégorie *</label>
                                            <input type="text"  class="form-control" name="nom" id="nom_categorie"  required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="categoriearticle_id" class="form-label">Catégorie</label>
                                            <select name="categoriearticle_id" id="categoriearticle_id"  class="form-select" >                                                    
                                                
                                                @foreach ($categoriearticles as $categoriearticle)                                                        
                                                    <option value="{{$categoriearticle->id}}">{{$categoriearticle->nom}}</option>
                                                @endforeach
                                            </select>
                                        </div> 
                                    </div>
    
                                </div>
                                <div class="row categorie_cree" style="margin-top: 20px">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="wp_id" class="form-label">ID de la catégorie *</label>
                                            <input type="text"  class="form-control" name="wp_id" id="wp_id"  >
                                        </div>
                                    </div>
    
                                </div>
                                <div class="row categorie_cree" style="margin-top: 20px">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="url" class="form-label">URL de la catégorie *</label>
                                            <input type="text"  class="form-control" name="url" id="url"  >
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


        <!-- Modal Edit Catégorie -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
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
                                        <label for="edit_nom" class="form-label">Nom du catégorie</label>
                                        <input type="text"  class="form-control" name="nom" id="edit_nom"  required>
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



    
</div> <!-- End Content -->
<style>
    .border-action {
        border: 1px solid #094077!important;
        border-style: dashed!important;
        border-width: 2px!important;
        background-color: beige;
    }

    .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn){
        width: 100%;
        
    }
    .btn-light:hover {
        background-color: #ffffff;
        border-color: #f0f3f8;
    }
    .btn-light {
        background-color: #ffffff;
        border-color: #f0f3f8;
        height: calc(3.5rem + 2px);
 
    }
</style>



@endsection

@section('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


{{-- Ajout d'une catégorie--}}
<script>
    $('.categorie_cree').hide();

    $('.add_categorie').on( 'click',function (e) {

        let that = $(this);
        $('#nom_site').text(that.data('nom')) ;
        $('#siteinterne_id').val(that.data('site_id')) ;

    });

    $('#categorie_cree').change(function(e){

    let cate = $('#categorie_cree').val();
    if(cate == "oui"){
        $('.categorie_cree').show();
    }else{
        $('.categorie_cree').hide();
    }


})
</script>

{{-- Modification d'une catégorie --}}
<script>
    $('.modifier').on( 'click',function (e) {

        let that = $(this);
        $('#edit_nom').val(that.data('nom')) ;
        $('#edit_url').val(that.data('url')) ;

        $('#edit_pays').val(that.data('pays')) ;
        

        let siteinterneId = that.data('siteinterne_id') ;

        $('#edit_siteinterne_id option[value='+siteinterneId+']').attr('selected','selected');

        let currentFormAction = that.data('href');
        $('#form-edit').attr('action', currentFormAction) ;

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/i18n/defaults-fr_FR.js"></script>
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