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
                <h4 class="page-title">{{$alerte->nom}}</h4>
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
                                    <h3><span class="text-danger">{{$alerte->valeur_action}}</span></h3>
                                    <p class="text-muted font-15 mb-0">Valeur de fermerture à la veille</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6 col-lg-3">
                            <div class="card shadow-none m-0 border-end">
                                <div class="card-body text-center">
                                    <i class="dripicons-lock-open text-muted " style="font-size: 24px;"></i>
                                    <h3><span class="text-success">{{$alerte->valeur_action}}</span></h3>
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


    <!-- end row-->
    <div class="row">

  

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