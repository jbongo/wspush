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
                        <li class="breadcrumb-item active">Articles</li>
                    </ol>
                </div>
                <h4 class="page-title">Tous les Articles</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        @can('permission', 'ajouter-article')                        
                        <div class="col-sm-2 mr-14 ">
                            <a href="{{route('article.add')}}" type="button" class="btn btn-outline-primary"><i class="uil-plus"></i> Ajouter</a>
                        </div>
                        @endcan
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
                            <div class="alert alert-warning alert-dismissible bg-warning text-white text-center border-0 fade show" role="alert">
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
                        <ul class="nav nav-tabs nav-bordered mb-3">
                            <li class="nav-item">
                                <a href="#article-interne" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Articles internes</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('article.index_externe')}}"  class="nav-link ">
                                    {{-- <a href="#article-externe" data-bs-toggle="tab" aria-expanded="true" class="nav-link "> --}}
                                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                    <span class="d-none d-md-block">Articles externes</span>
                                </a>
                            </li>
                           
                        </ul>
                        
                        <div class="tab-content">
                            <div class="tab-pane show active" id="article-interne">
                              
                                
                                 
                                <table class="table table-centered w-100 dt-responsive nowrap" id="action-achete-datatable">
                                    <thead class="table-lightx" style="background-color: #69075a; color:#fff;">
                                        <tr>
                                            <th scope="col">Image</th>
                                            <th scope="col">Titre</th>
                                            <th scope="col">Catégorie</th>
                                            <th scope="col">Date de création</th>
                                            <th scope="col">Statut</th>
                               
                                            
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    
                                  
                                    
                                    <tbody>
                                    
                                    @foreach ($articles as $article)
                                                                   
                                        <tr>
                                           
                                      
                                            <td>
                                                <div class="d-flex align-items-center" class="img-wrapper">
                                                    @if(sizeof($article->images)> 0)
                                                        <a href="{{route('article.edit_no_scrap', Crypt::encrypt($article->id))}}" >
                                                            <img src="/images-articles/{{$article->images[0]->filename}}" style=" border-radius: 3px;" height="50px" width="60px" alt=""> 
                                                        </a>      
                                                    @endif                                      
                                                </div>
                                            </td>
                                
                                
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 ms-2 fw-bold " style="font-size: 16px">
                                                        <a href="{{route('article.edit_no_scrap', Crypt::encrypt($article->id))}}" class="text-secondary" > {{substr($article->titre,0,50)}}...</a>
                                                    </div>                                                    
                                                </div>
                                            </td>
                                             <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 ms-2 fw-bold"><span class="text-danger">{{$article->categoriearticle->nom}}</span></div>
                                                </div> 
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center" class="img-wrapper">
                                                    <div class="flex-grow-1 ms-2 fw-bold"><span class="text-secondary">{{$article->created_at->format('d/m/Y')}}</span></div>
                                                  
                                                </div>
                                            </td>
                                           
                                             <td>
                                                <div class="d-flex align-items-center">                                            
                                                    @if($article->est_publie == true)<p class="mb-0 text-success">  Publié  </p> @else <p class="mb-0  text-secondary"> Non publié </p>  @endif
                                                </div> 
                                            </td>
                                       
                                         <td>
                                            @can('permission', 'modifier-article')                        

                                                <a href="{{route('article.edit_no_scrap', Crypt::encrypt($article->id))}}" class="text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier"><i class="mdi mdi-square-edit-outline"></i></a>
                                                @else                                 
                                                <a  class="text-secondary" style="cursor: no-drop;" data-bs-toggle="tooltip" data-bs-placement="top" title="Permission non accordée" ><i class="mdi mdi-square-edit-outline"></i></a>
                                            @endcan
                                
                                                {{-- 
                                                <a href="{{route('article.show', Crypt::encrypt($article->id))}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Détail"><i class="mdi mdi-eye-outline"></i></a>
                                                <a href="{{route('article.archiver', Crypt::encrypt($article->id))}}" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Dupliquer l'action"><i class="mdi mdi-content-duplicate"></i></a> --}}
                                
                                              
                                        
                                            </td>
                                            
                                            
                                        </tr> <!-- end tr -->
                                
                                    @endforeach
                                
                                    </tbody>
                                </table>
                               
                            </div>
                            <div class="tab-pane " id="article-externe">
                              
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->

        
         <!-- Modal -->
         <div class="modal fade" id="addActionModal" tabindex="-1" aria-labelledby="addActionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{route('article.store')}}" method="post">
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

    .img-wrapper {
        display: inline-block;
        overflow: hidden;

       
        
    }

    img:hover {
        transform:scale(4.5);
        -ms-transform:scale(4.5); /* IE 9 */
        -moz-transform:scale(4.5); /* Firefox */
        -webkit-transform:scale(4.5); /* Safari and Chrome */
        -o-transform:scale(4.5); /* Opera */
    }
</style>


@endsection

@section('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
 

 
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