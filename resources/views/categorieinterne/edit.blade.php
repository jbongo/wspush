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
                        <li class="breadcrumb-item"><a href="{{route('categorie_interne.index',Crypt::encrypt($categorieinterne->siteinterne_id))}}">Catégories internes</a></li>
                        <li class="breadcrumb-item active">Détails</li>
                    </ol>
                </div>
                <h4 class="page-title">Modifier la catégorie  <span class="text-danger"> {{$categorieinterne->nom}} </span> de {{$categorieinterne->siteinterne->nom}}
                / {{$categorieinterne->siteinterne->pay->nom}}
                </h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 

    
  {{-- {{dd($categorieinterne->siteinterne_id)}} --}}
    <!-- end row-->


    <div class="row">
        <div class="col-lg-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        
                        <div class="col-sm-2 mr-14 ">
                            <a href="{{route('categorie_interne.index',Crypt::encrypt($categorieinterne->siteinterne_id))}}" type="button" class="btn btn-outline-secondary"><i class="uil-arrow-left"></i> Retour</a>
                        </div>
                        @if(session('ok'))
                        <div class="col-6">
                            <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show text-center" role="alert">
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
    <!-- end row-->
    <div class="row">

  
     
        <div class="col-9 ">
            <div class="card">
                <div class="card-body">
                   
                    <form action="{{route('categorie_interne.update', Crypt::encrypt($categorieinterne->id))}}" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="addcategorieinterneModalLabel"><span class="text-danger"> {{$categorieinterne->nom}} </span> / {{$categorieinterne->siteinterne->nom}}</h4>
                                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                            </div>
                            <div class="modal-body">
                                
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="nom" class="form-label">Nom</label>
                                                <input type="text" class="form-control" name="nom" value="{{old('nom') ? old('nom') : $categorieinterne->nom}}" id="nom"  required>
                                                @if ($errors->has('nom'))
                                                  <br>
                                                    <div class="alert alert-danger" role="alert">
                                                        <i class="dripicons-wrong me-2"></i> <strong>{{$errors->first('nom')}}</strong> 
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="categoriearticle_id" class="form-label">Catégorie</label>
                                                <select name="categoriearticle_id" id="categoriearticle_id"  class="form-select" >   
                                                    
                                                    @if($categorieinterne->categoriearticle != null)
                                                    <option value="{{$categorieinterne->categoriearticle->id}}">{{$categorieinterne->categoriearticle->nom}}</option>
                                                    @endif
                                                    @foreach ($categoriearticles as $categoriearticle)                                                        
                                                        <option value="{{$categoriearticle->id}}">{{$categoriearticle->nom}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('categoriearticle_id'))
                                                  <br>
                                                    <div class="alert alert-danger" role="alert">
                                                        <i class="dripicons-wrong me-2"></i> <strong>{{$errors->first('categoriearticle_id')}}</strong> 
                                                    </div>
                                                @endif
                                            </div> 
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="wp_id" class="form-label">ID de la catégorie *</label>
                                                <input type="text" value="{{old('wp_id') ? old('wp_id') : $categorieinterne->wp_id}}"  class="form-control" name="wp_id" id="wp_id"  required>
                                                @if ($errors->has('wp_id'))
                                                <br>
                                                  <div class="alert alert-danger" role="alert">
                                                      <i class="dripicons-wrong me-2"></i> <strong>{{$errors->first('wp_id')}}</strong> 
                                                  </div>
                                              @endif
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="url" class="form-label">URL de la catégorie *</label>
                                                <input type="text" value="{{old('url') ? old('url') : $categorieinterne->url}}"  class="form-control" name="url" id="url"  required>
                                                @if ($errors->has('url'))
                                                <br>
                                                  <div class="alert alert-danger" role="alert">
                                                      <i class="dripicons-wrong me-2"></i> <strong>{{$errors->first('url')}}</strong> 
                                                  </div>
                                              @endif
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">

                                        <div class="col-6 table-responsive">
                                            <table class="table table-centered w-100 dt-responsive nowrap" id="action-achete-datatable">
                                                    <thead class="table-lightx" style="background-color: #17a2b8; color:#fff;">
                                                        <tr>                                  
                                                            <th scope="col">Sites Sources</th>
                                                            <th scope="col">#</th>
                                                                                         
                                                        </tr>
                                                    </thead>
                                                    
                                                  
                                                    
                                                    <tbody>
                                                    
                                                        @foreach ($siteexternes as $siteexterne)
                                                            
                                                            <tr>

                                                                <td><span class="flex-grow-1 ms-2 fw-bold text-primary " style="font-size: 20px">{{$siteexterne->nom}}</span></td>
                                                            </tr>
                                                            
                                                            @foreach ($siteexterne->categorieexternes as $categorieexterne)
                                                                <tr>
                                                                    <td>
                                                                        <label for="{{$categorieexterne->id}}" style="margin-left: 5px">{{$categorieexterne->nom}}</label>
                                                                        <input type="checkbox" @if($categorieinterne->HaveCategorieexterne($categorieexterne->id)) checked @endif 
                                                                            name="{{$categorieexterne->id}}" id="{{$categorieexterne->id}}">
                                                                        
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                            
                                                        @endforeach
                            
                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>
                                    
                                    
                                    
                                                                        
                            </div>
                            <div class="modal-footer">
                                <a  class="btn btn-light" href="{{route('categorie_interne.index',Crypt::encrypt($categorieinterne->siteinterne_id))}}">Annuler</a>
                                <button type="submit" class="btn btn-success">Modifier</button>
                            </div>
                        </div>
                    </form> 
           
                </div>
            </div>
        </div> <!-- end col -->
        
        <div class="col-3 ">
            <div class="card">
                <div class="card-body">
                   
                    <form action="{{route('categorie_interne.update', Crypt::encrypt($categorieinterne->id))}}" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="addcategorieinterneModalLabel"><span class="text-danger"> Choisir le pays </span> </h4>
                                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                            </div>
                            <div class="modal-body">
                                
                                    @csrf                     
                                    
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <select  class="form-select" name="pays"  id="pays" >
                                                @if($paysSelect == "all")
                                                    <option value="all">Tous les pays</option>
                                                @else
                                                    <option value="{{$paysSelect->id}}">{{$paysSelect->nom}}</option>                                                         

                                                @endif
                                                <option value="all">Tous les pays</option>

                                                @foreach ($pays as $pay)
                                                    <option value="{{$pay->id}}">{{$pay->nom}}</option>                                                         
                                                @endforeach
                                            </select>
                                            
                                            
                                            @if ($errors->has('pays'))
                                              <br>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="dripicons-wrong me-2"></i> <strong>{{$errors->first('pays')}}</strong> 
                                                </div>
                                            @endif
                                        </div>
                                       
                                      
                                    </div>
                                                                        
                            </div>
                            
                        </div>
                    </form> 
           
                </div>
            </div>
        </div> <!-- end col -->
        
        
        
        
    </div> <!-- end row -->

    
</div> <!-- End Content -->


@endsection

@section('script')

<script>

    let url = "{{$url}}";
    
    // Choix du pays
    $('#pays').change(function(e){

        window.location.href=url+'/'+e.currentTarget.value;

    });

</script>
@endsection