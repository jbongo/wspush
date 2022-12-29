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
                        <li class="breadcrumb-item"><a href="{{route('action.index')}}">Titres</a></li>
                        <li class="breadcrumb-item active">Détails</li>
                    </ol>
                </div>
                <h4 class="page-title">{{$action->nom}}</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 

    
    
    <div class="row">
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        

                        <div class="col-sm-6 col-lg-3">
                            <div class="card shadow-none m-0 border-end ">
                                <div class="card-body text-center">
                                    <i class="dripicons-lock text-muted " style="font-size: 24px;"></i>
                                    <h3><span class="text-danger">{{$action->valeuraction()->valeur_cloture_veille}}</span></h3>
                                    <p class="text-muted font-15 mb-0">Valeur de fermerture à la veille</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6 col-lg-3">
                            <div class="card shadow-none m-0 border-end">
                                <div class="card-body text-center">
                                    <i class="dripicons-lock-open text-muted " style="font-size: 24px;"></i>
                                    <h3><span class="text-success">{{$action->valeuraction()->valeur_ouverture}}</span></h3>
                                    <p class="text-muted font-15 mb-0">Valeur d'ouverture</p>
                                </div>
                            </div>
                        </div>


                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-box-->
        </div> <!-- end col-->
    </div>
    
    <!-- end row-->


    <div class="row">
        <div class="col-lg-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        
                    <form action="{{route('action.show', Crypt::encrypt($action->id))}}" method="GET">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                            <label for="date_deb"> Date de début</label>
                              <input type="date" class="form-control" id="date_deb" @if(isset($_GET['date_deb'])) value="{{$_GET['date_deb']}}" @endif name="date_deb" placeholder="Date début">
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <label for="date_fin"> Date de fin</label>
                              <input type="date" class="form-control" id="date_fin" @if(isset($_GET['date_fin'])) value="{{$_GET['date_fin']}}" @endif name="date_fin" placeholder="Date fin">
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

  

        <div class="col-xxl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        {{-- <h4 class="header-title mb-0">Transaction List</h4> --}}
                        <div>
                            <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                <option selected>Aujourdh'ui</option>
                                <option value="1">Hier</option>

                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                    <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Date </th>
                                    <th scope="col">Heure </th>
                                    <th scope="col">Valeur (EUR)</th>
                                    <th scope="col">Pourcentage (%)</th>
                                    <th scope="col">Volume Achat </th>
                                    <th scope="col">Volume Vente </th>
                                    <th scope="col">Valeur Haute (EUR)</th>
                                    <th scope="col">Valeur Basse (EUR)</th>
                              
                                </tr>
                            </thead>
                            
                          
                            
                            <tbody>
                            
                            @foreach ($valeuractions as $valeur )
                                
                            
                                <tr>
                                   
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 ms-2">{{$valeur->created_at->format('d/m/Y')}}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 ms-2">{{$valeur->created_at->format('H:i')}} </div>
                                        </div>
                                    </td>
                                     <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 ms-2 fw-bold">{{$valeur->valeur}}</div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($valeur->pourcentage < 0) <i class="uil uil-chart-down text-danger me-1"></i> @else <i class="uil uil-arrow-growth text-success me-1"></i> @endif {{$valeur->pourcentage}} 
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 ms-2">{{$valeur->volume_achat}} </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 ms-2">{{$valeur->volume_vente}} </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-success fw-semibold">{{$valeur->valeur_haute}}</span>
                                    </td>
                                    <td>
                                        <span class="text-danger fw-semibold">{{$valeur->valeur_basse}}</span>
                                    </td>
                                    
                                    
                                </tr> <!-- end tr -->
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    
    
   
    
</div> <!-- End Content -->


@endsection

@section('script')
<script src="{{asset('assets/js/vendor/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('assets/js/vendor/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/responsive.bootstrap5.min.js')}}"></script>
{{-- <script src="{{asset('assets/js/vendor/dataTables.checkboxes.min.js')}}"></script> --}}
{{-- <script src="{{asset('assets/js/pages/demo.products.js')}}"></script> --}}

<script>
$(document).ready(function()
{
    "use strict";
    $("#products-datatable").
        DataTable(
        {
        language:{paginate:{previous:"<i class='mdi mdi-chevron-left'>",
        next:"<i class='mdi mdi-chevron-right'>"},
        info:"Showing titres _START_ to _END_ of _TOTAL_",
        lengthMenu:'Display <select class=\'form-select form-select-sm ms-1 me-1\'><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> titres'},
        pageLength:100,
        // columns:[
        // {
        //     orderable:!1,targets:0,render:function(e,l,a,o){return"display"===l&&(e='<div class="form-check"><input type="checkbox" class="form-check-input dt-checkboxes"><label class="form-check-label">&nbsp;</label></div>'),e},
        //     checkboxes:{selectRow:!0,selectAllRender:'<div class="form-check"><input type="checkbox" class="form-check-input dt-checkboxes"><label class="form-check-label">&nbsp;</label></div>'}
        // },
        // {orderable:!0},
        // {orderable:!0}
        // ,{orderable:!0},{orderable:!0},{orderable:!0},{orderable:!0},{orderable:!1}],
        select:{style:"multi"},
        drawCallback:function(){$(".dataTables_paginate > .pagination").addClass("pagination-rounded"),
        // $("#products-datatable_length label").addClass("form-label"),
        document.querySelector(".dataTables_wrapper .row").querySelectorAll(".col-md-6").forEach(function(e){e.classList.add("col-sm-6"),e.classList.remove("col-sm-12"),e.classList.remove("col-md-6")})}})});
</script>
@endsection