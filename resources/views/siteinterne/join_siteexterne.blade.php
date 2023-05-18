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
                        <li class="breadcrumb-item"><a href="{{route('site_interne.index')}}">Sites internes</a></li>
                        <li class="breadcrumb-item active">Sites sources</li>
                    </ol>
                </div>
                <h4 class="page-title">Choisir les sites sources de <span class="text-danger"> {{$site->nom}} </span> </h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 
  
    <!-- end row-->


    <div class="row">
        <div class="col-lg-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        
                        <div class="col-sm-2 mr-14 ">
                            <a href="{{route('categorie_interne.index',Crypt::encrypt($site->id))}}" type="button" class="btn btn-outline-secondary"><i class="uil-arrow-left"></i> Retour</a>
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

  

        <div class="col-12 ">
            <div class="card">
                <div class="card-body">
                   
                    <form action="{{route('categorie_interne.update', Crypt::encrypt($site->id))}}" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="addcategorieinterneModalLabel"><span class="text-danger"> {{$site->nom}} </span> </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                
                                    @csrf
                                 

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
                                                    
                                                        @foreach ($pays as $pay)
                                                            
                                                            <tr>

                                                                <td><span class="flex-grow-1 ms-2 fw-bold text-primary " style="font-size: 20px">{{$pay->nom}}</span></td>
                                                            </tr>
                                                            
                                                            @foreach ($pay->siteexternes as $siteexterne)
                                                                <tr>
                                                                    <td>
                                                                        <label for="{{$siteexterne->id}}" style="margin-left: 5px">{{$siteexterne->nom}}</label>
                                                                        <input type="checkbox" 
                                                                            name="{{$siteexterne->id}}" id="{{$siteexterne->id}}"></td>
                                                                </tr>
                                                            @endforeach
                            
                                                        @endforeach
                            
                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>
                                    
                                    
                                    
                                                                        
                            </div>
                            <div class="modal-footer" style="position: fixed;bottom: 10px; margin: 0;  left: 50%; z-index:1 ;">
                                <a  class="btn btn-light btn-lg" href="{{route('categorie_interne.index',Crypt::encrypt($site->siteinterne_id))}}">Annuler</a>
                                <button type="submit" class="btn btn-success btn-lg">Modifier</button>
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


@endsection