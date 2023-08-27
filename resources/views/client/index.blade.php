@extends('layouts.app')
    @section('css')
    <link href="{{asset('assets/css/vendor/dataTables.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/vendor/responsive.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/dist/css/bootstrap-select.css') }}">

    @endsection
@section('content')
<div class="content">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Clients</li>
                    </ol>
                </div>
                <h4 class="page-title">Clients</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                <div class="row mb-2">
                    @can('permission', 'ajouter-client')

                    <div class="col-sm-5">
                        <a href="javascript:void(0);" class="btn btn-primary mb-2"  data-bs-toggle="modal" data-bs-target="#standard-modal"><i class="mdi mdi-plus-circle me-2"></i> Nouveau client</a>
                    </div>
                    @endcan
                    <div class="col-sm-7">
                        
                    </div><!-- end col-->
                </div>
                <div class="row">
                
                    <div class="col-6">
                        @if(session('message'))       
                            <div class="alert alert-success text-secondary alert-dismissible ">
                                <i class="dripicons-checkmark me-2"></i>
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <a href="#" class="alert-link"><strong> {{ session('message')}}</strong></a> 
                            </div>
                        @endif 
                        @if ($errors->has('client'))
                            <br>
                            <div class="alert alert-warning text-secondary " role="alert">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>{{$errors->first('client')}}</strong> 
                            </div>
                        @endif
                        <div  id="div-client-message" class="alert alert-success text-secondary alert-dismissible fade in">
                            <i class="dripicons-checkmark me-2"></i>
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <a href="#" class="alert-link"><strong> <span id="client-message"></span></strong></a> 
                        </div>

                    </div>
                </div>
                
                    <div class="table-responsive">
                        <table class="table table-centered w-100 dt-responsive nowrap" id="user-datatable">
                            <thead class="table-lightx" style="background-color: #17a2b8; color:#fff;">
                                <tr>                                
                                    <th>Raison sociale / Nom</th>
                                    <th>Utilisateurs</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Pays</th>
                                    <th>Langue</th>
                                    <th>Statut</th>

                                    <th style="width: 125px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)                                    
                                
                                <tr>
                                    
                                    <td><a href="#" class="text-body fw-bold">{{$client->raison_sociale}}</a> </td>
                                    <td><a href="#" class="btn btn-info btn-sm rounded-pill">{{$client->nbUsers()}} </a> </td>
                                    <td><a href="#" class="text-body fw-bold">{{$client->email}}</a> </td>
                                    <td><a href="#" class="text-body fw-bold">{{$client->contact1}} - {{$client->contact2}}</a> </td>
                                                <td>
                                      <span class="text-danger">{{$client->pay->nom}}</span>
                                    </td>
                                    <td>
                                        <span class="text-danger">{{$client->langue->nom}}</span>
                                    </td>
                                    <td>
                                        @if($client->est_archive == false) <span class="badge bg-success">Actif</span>
                                        @else<span class="badge bg-warning">Archivé</span>@endif
                                    </td>
                                    <td>
                                        {{-- <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-eye"></i></a> --}}
                                        @can('permission', 'modifier-client')

                                        <a data-href="{{route('client.update', Crypt::encrypt($client->id))}}" data-raison_sociale="{{$client->raison_sociale}}" data-contact1="{{$client->contact1}}" data-contact2="{{$client->contact2}}"
                                            data-email="{{$client->email}}" data-pays_id="{{$client->pay_id}}"  data-langue_id="{{$client->langue_id}}" 
                                            data-bs-toggle="modal" data-bs-target="#edit-modal" class="action-icon edit-client text-success"> <i class="mdi mdi-square-edit-outline"></i></a>
                                        @else
                                            <a  class="text-secondary" style="cursor: no-drop;" data-bs-toggle="tooltip" data-bs-placement="top" title="Permission non accordée" ><i class="mdi mdi-square-edit-outline"></i></a>

                                        @endcan

                                        @can('permission', 'archiver-client')

                                            @if($client->archive == false)
                                            <a data-href="{{route('client.archive', $client->id)}}" style="cursor: pointer;" class="action-icon archive-client text-warning"> <i class="mdi mdi-archive-arrow-down"></i></a>
                                            @else
                                            <a data-href="{{route('client.unarchive', $client->id)}}" style="cursor: pointer;" class="action-icon unarchive-client text-success"> <i class="mdi mdi-archive-arrow-up"></i></a>
                                            @endif
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->  
    
    {{-- Ajout d'un client --}}
<div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Ajouter un client</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{route('client.store')}}" method="post" autocomplete="off">
            <div class="modal-body ">
            
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="raison_sociale" value="{{old('raison_sociale') ? old('raison_sociale') : ''}}" class="form-control" id="raison_sociale"  required>
                            <label for="raison_sociale">Raison sociale</label>
                            @if ($errors->has('raison_sociale'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('raison_sociale')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="email" name="email" value="{{old('email') ? old('email') : ''}}" class="form-control" id="email"  required>
                            <label for="email">Email</label>
                            @if ($errors->has('email'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('email')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>

                
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <select class="selectpicker form-control" name="pays_id" id="pays_id"    data-live-search="true" required>
                                <option value="">Pays du client</option>

                                @foreach ($pays as $pay)
                                    <option value="{{$pay->id}}"  data-tokens="{{$pay->nom}}"> {{$pay->nom}}</option>
                                @endforeach
                            </select>
                            {{-- <label for="pays_id">Pays du client</label> --}}
                           
                            @if ($errors->has('pays_id'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('pays_id')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>        

                    <div class="col-6">
                        <div class="form-floating mb-3">
           
                            <select class="form-control selectpicker" name="langue_id" id="langue_id" data-live-search="true" required>
                                <option value="">Langue du client</option>
                                @foreach ($langues as $langue)
                                    <option value="{{$langue->id}}"> {{$langue->nom}}</option>
                                @endforeach
                            </select>
                            {{-- <label for="langue_id">Langue du client</label> --}}
                            @if ($errors->has('langue_id'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('langue_id')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>

                
                </div>



                <div class="row">
                    
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="contact1" value="{{old('contact1') ? old('contact1') : ''}}" class="form-control" id="contact1" >
                            <label for="contact1">Téléphone 1</label>
                            @if ($errors->has('contact1'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('contact1')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="contact2" value="{{old('contact2') ? old('contact2') : ''}}" class="form-control" id="contact1" >
                            <label for="contact2">Téléphone 2</label>
                            @if ($errors->has('contact2'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('contact2')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

    
        

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>

            </div>
        </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<style>
    .form-floating>.form-control:focus, .form-floating>.form-control:not(:placeholder-shown) {
        padding-top: 0.01rem;
        height: 65px;
        padding-bottom: 0.625rem;
    }
</style>

    {{-- Modification d'un client --}}
    <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Modifier le client</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" method="post" id="form-edit" autocomplete="off">
            <div class="modal-body">
            
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="raison_sociale" value="{{old('raison_sociale') ? old('raison_sociale') : ''}}" class="form-control" id="edit-raison_sociale"  required>
                            <label for="edit-raison_sociale">Raison sociale</label>
                            @if ($errors->has('raison_sociale'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('raison_sociale')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="email" name="email" value="{{old('email') ? old('email') : ''}}" class="form-control" id="edit-email"  required>
                            <label for="edit-email">Email</label>
                            @if ($errors->has('email'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('email')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>

                
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <select class=" form-select" name="pays_id" id="edit-pays_id"    data-live-search="true" required>
                                {{-- <option value="">Pays du client</option> --}}

                                @foreach ($pays as $pay)
                                    <option value="{{$pay->id}}"  data-tokens="{{$pay->nom}}"> {{$pay->nom}}</option>
                                @endforeach
                            </select>
                            <label for="pays_id">Pays du client</label>
                           
                            @if ($errors->has('pays_id'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('pays_id')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>        

                    <div class="col-6">
                        <div class="form-floating mb-3">
           
                            <select class="form-select " name="langue_id" id="edit-langue_id" data-live-search="true" required>
                                {{-- <option value="">Langue du client</option> --}}
                                @foreach ($langues as $langue)
                                    <option value="{{$langue->id}}"> {{$langue->nom}}</option>
                                @endforeach
                            </select>
                            <label for="langue_id">Langue du client</label>
                            @if ($errors->has('langue_id'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('langue_id')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>

                
                </div>



                <div class="row">
                    
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="contact1" value="{{old('contact1') ? old('contact1') : ''}}" class="form-control" id="edit-contact1" >
                            <label for="edit-contact1">Téléphone 1</label>
                            @if ($errors->has('contact1'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('contact1')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="contact2" value="{{old('contact2') ? old('contact2') : ''}}" class="form-control" id="edit-contact1" >
                            <label for="edit-contact2">Téléphone 2</label>
                            @if ($errors->has('contact2'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('contact2')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

    

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-success">Modifier</button>

            </div>
        </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



</div> <!-- End Content -->

@endsection   

@section('script')
<script src="{{asset('assets/js/vendor/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/dataTables.bootstrap5.js')}}"></script>
{{-- <script src="{{asset('assets/js/vendor/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/responsive.bootstrap5.min.js')}}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

{{-- Modification d'un client --}}
<script>

$('.edit-client').click(function (e) {

        let that = $(this);
        let currentRaisonSociale = that.data('raison_sociale');
        let currentContact1 = that.data('contact1');
        let currentContact2 = that.data('contact2');
        let currentEmail = that.data('email');

        let currentPaysId = that.data('pays_id');
        let currentLangueId = that.data('langue_id');

 
        let currentFormAction = that.data('href');
        $('#edit-raison_sociale').val(currentRaisonSociale) ;
        $('#edit-contact1').val(currentContact1) ;
        $('#edit-contact2').val(currentContact2) ;
        $('#edit-email').val(currentEmail) ;
        $('#edit-pays_id option[value='+currentPaysId+']').attr("selected",true);
        $('#edit-langue_id option[value='+currentLangueId+']').attr("selected",true);
        $('#form-edit').attr('action', currentFormAction) ;

   
})

</script>


<script>
    $(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
        $('[data-toggle="tooltip"]').tooltip()
        $('body').on('click','a.archive-client',function(event) {
            let that = $(this)
            event.preventDefault();

            const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            });

            swalWithBootstrapButtons.fire({
            title: 'Archiver',
            text: "Confirmer ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui',
            cancelButtonText: 'Non',
            reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                
                $('[data-toggle="tooltip"]').tooltip('hide')
                    $.ajax({                        
                        url: that.attr('data-href'),
                        type: 'PUT',
                        success: function(data){
                            // document.location.reload();
                        },
                        error : function(data){
                        console.log(data);
                        }
                    })
                    .done(function () {

                        swalWithBootstrapButtons.fire(
                            'Archivé',
                            '',
                            'success'
                        )
                            document.location.reload();

                            // that.parents('tr').remove();
                    })
               

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                'Annulé',
                'Utilisateur non archivé :)',
                'error'
                )
            }
            }); 
            })

    });


</script>

<script>

    // Désarchiver

    $(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
        $('[data-toggle="tooltip"]').tooltip()
        $('body').on('click','a.unarchive-client',function(event) {
            let that = $(this)
            event.preventDefault();
            
            const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            });

            swalWithBootstrapButtons.fire({
            title: 'Désarchiver',
            text: "Confirmer ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui',
            cancelButtonText: 'Non',
            reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                
                $('[data-toggle="tooltip"]').tooltip('hide')
                    $.ajax({                        
                        url:that.attr('data-href'),
                        // url:"/client/desarchiver/2",
                        
                        type: 'POST',
                        success: function(data){
                           
                            // document.location.reload();
                        },
                        error : function(data){
                        console.log(data);
                        }
                    })
                    .done(function () {

                        swalWithBootstrapButtons.fire(
                            'Désarchivé',
                            '',
                            'success'
                            )
                        document.location.reload();
                    })
                

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                'Annulé',
                'Utilisateur non désarchivé :)',
                'error'
                )
            }
            }); 
            })

    });
   

</script>

<script>
    $(document).ready(function()
    {
        "use strict";
        $("#user-datatable").
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

