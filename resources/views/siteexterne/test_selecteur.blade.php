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
                        <li class="breadcrumb-item"><a href="{{route('site_externe.index')}}">Sites externes</a></li>
                        <li class="breadcrumb-item active">Tester selecteurs</li>
                    </ol>
                </div>
                
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
                            <a href="{{route('site_externe.index')}}" type="button" class="btn btn-outline-primary"><i class="uil-arrow-left"></i> Sites externes</a>
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
    <!-- end row-->
    <div class="row">

  

        <div class="col-12 ">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-6">

                            <form action="{{route('scrap.tester_selecteur', 'lien')}}" target="_blank" method="post">                
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="links_selector" class="form-label">Selecteur liens</label>
                                            <input type="text" class="form-control" name="links_selector" value="" id="links_selector" >                                    
                                        </div>                           
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="url" class="form-label">url de la catégorie externe</label>
                                            <input type="text" class="form-control" name="url" value="" id="url" >                                    
                                        </div>                           
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="title_selector" class="form-label">Selecteur titre</label>
                                            <input type="text" class="form-control" name="title_selector" value="" id="title_selector" >                                    
                                        </div>                           
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="content_selector" class="form-label">Selecteur contenu</label>
                                            <input type="text" class="form-control" name="content_selector" value="" id="content_selector" >                                    
                                        </div>                           
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="image_selector" class="form-label">Selecteur image</label>
                                            <input type="text" class="form-control" name="image_selector" value="" id="imagent_selector" >                                    
                                        </div>                           
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="image_affiche_css" class="form-label">Selecteur image css ? </label>
                                            <select name="image_affiche_css" id="image_affiche_css"  class="form-select" >                                                    
                                                <option value="non">non</option>
                                                <option value="oui">oui</option>
                                             
                                            </select>
                                        </div> 
                                        
                                    </div>

                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">&nbsp;</label>
                                            <button type="submit" class="btn btn-danger form-control    ">Tester</button>                                   
                              
                                        </div>                           
                                    </div>
                                </div>
                            </form> 
                   
                        </div>

                        <div class="col-6">

                                

                        </div>
                        <div class="col-6">


                        </div>
                        <div class="col-6">


                        </div>
                    </div>
                   
                
                </div>
            </div>
        </div> <!-- end col -->
        
       
        
        
    </div> <!-- end row -->
    

    
</div> <!-- End Content -->


@endsection

@section('script')

@endsection