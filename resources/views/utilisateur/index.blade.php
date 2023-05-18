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
                        <li class="breadcrumb-item active">Utilisateurs</li>
                    </ol>
                </div>
                <h4 class="page-title">Utilisateurs</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-5">
                        <a href="javascript:void(0);" class="btn btn-primary mb-2"  data-bs-toggle="modal" data-bs-target="#standard-modal"><i class="mdi mdi-plus-circle me-2"></i> Nouvel utilisateur</a>
                    </div>
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
                        @if ($errors->has('utilisateur'))
                            <br>
                            <div class="alert alert-warning text-secondary " role="alert">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>{{$errors->first('utilisateur')}}</strong> 
                            </div>
                        @endif
                        <div  id="div-utilisateur-message" class="alert alert-success text-secondary alert-dismissible fade in">
                            <i class="dripicons-checkmark me-2"></i>
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <a href="#" class="alert-link"><strong> <span id="utilisateur-message"></span></strong></a> 
                        </div>

                    </div>
                </div>
                
                    <div class="table-responsive">
                        <table class="table table-centered w-100 dt-responsive nowrap" id="user-datatable">
                            <thead class="table-lightx" style="background-color: #17a2b8; color:#fff;">
                                <tr>
                                
                                    <th>Nom</th>
                                    <th>Prénom(s)</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Statut</th>

                                    <th style="width: 125px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($utilisateurs as $utilisateur)
                                    
                                
                                <tr>
                                    
                                    <td><a href="#" class="text-body fw-bold">{{$utilisateur->nom}}</a> </td>
                                    <td><a href="#" class="text-body fw-bold">{{$utilisateur->prenom}}</a> </td>
                                    <td><a href="#" class="text-body fw-bold">{{$utilisateur->email}}</a> </td>
                                    <td>
                                      <span class="text-danger">{{$utilisateur->role->nom}}</span>
                                    </td>
                                    <td>
                                        @if($utilisateur->archive == false) <span class="badge bg-success">Actif</span>
                                        @else<span class="badge bg-warning">Archivé</span>@endif
                                    </td>
                                    <td>
                                        {{-- <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-eye"></i></a> --}}
                                        <a data-href="{{route('utilisateur.update', Crypt::encrypt($utilisateur->id))}}" data-nom="{{$utilisateur->nom}}" data-prenom="{{$utilisateur->prenom}}" data-email="{{$utilisateur->email}}"
                                            data-client_id="{{$utilisateur->client_id}}"  data-role_id="{{$utilisateur->role_id}}" 
                                            data-bs-toggle="modal" data-bs-target="#edit-modal" class="action-icon edit-utilisateur text-success"> <i class="mdi mdi-square-edit-outline"></i></a>
                                        @if($utilisateur->archive == false)
                                        <a data-href="{{route('utilisateur.archive', $utilisateur->id)}}" style="cursor: pointer;" class="action-icon archive-utilisateur text-warning"> <i class="mdi mdi-archive-arrow-down"></i></a>
                                        @else
                                        <a data-href="{{route('utilisateur.unarchive', $utilisateur->id)}}" style="cursor: pointer;" class="action-icon unarchive-utilisateur text-success"> <i class="mdi mdi-archive-arrow-up"></i></a>
                                        @endif
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
    
    {{-- Ajout d'un utilisateur --}}
<div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Ajouter un utilisateur</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{route('utilisateur.store')}}" method="post" autocomplete="off">
            <div class="modal-body ">
            
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="nom" value="{{old('nom') ? old('nom') : ''}}" class="form-control" id="floatingInput" >
                            <label for="floatingInput">Nom</label>
                            @if ($errors->has('nom'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('nom')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="prenom" value="{{old('prenom') ? old('prenom') : ''}}" class="form-control" id="prenom" >
                            <label for="prenom">Prénom</label>
                            @if ($errors->has('prenom'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('prenom')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="email" value="{{old('email') ? old('email') : ''}}" class="form-control" id="email" >
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

                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <label for="password">Mot de passe</label>
                            <div class="input-group input-group-merge">
                                <input type="password" name="password" value="{{old('password') ? old('password') : ''}}" class="form-control" id="password" >
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                           
                            @if ($errors->has('password'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('password')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-floating mb-3">
                          <select name="role_id" id="role_id" class="form-select" required>

                            @foreach ($roles as $role)
                                <option value="{{$role->id}}"> {{$role->nom}}</option>
                            @endforeach
                          </select>
                            <label for="role_id">Rôle</label>
                            @if ($errors->has('role_id'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('role_id')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <div class="form-floating mb-3">
                          <select name="client_id" id="client_id" class="form-select" required>
                            <option value=""></option>
                            @foreach ($clients as $client)
                                <option value="{{$client->id}}"> {{$client->raison_sociale}}</option>
                            @endforeach
                          </select>
                            <label for="client_id">Client</label>
                            @if ($errors->has('client_id'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('client_id')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-check form-checkbox-secondary mb-3">
                            <label class="form-check-label" for="mail">Envoyer un mail de réinitialisation du mot de passe</label>
                            <input type="checkbox" name="mail" id="mail" class="form-check-input ">
                            @if ($errors->has('mail'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('mail')}}</strong> 
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


    {{-- Modification d'un utilisateur --}}
    <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Modifier le utilisateur</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" method="post" id="form-edit" autocomplete="off">
            <div class="modal-body">
            
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="nom" value="{{old('nom') ? old('nom') : ''}}" class="form-control" id="edit-nom" >
                            <label for="edit-nom">Nom</label>
                            @if ($errors->has('nom'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('nom')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="prenom" value="{{old('prenom') ? old('prenom') : ''}}" class="form-control" id="edit-prenom" >
                            <label for="edit-prenom">Prénom</label>
                            @if ($errors->has('prenom'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('prenom')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="email" value="{{old('email') ? old('email') : ''}}" class="form-control" id="edit-email" >
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

                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <label for="password">Mot de passe</label>
                            <div class="input-group input-group-merge">
                                <input type="password" name="password" value="" class="form-control" id="edit-password" autocomplete="new-password">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                           
                            @if ($errors->has('password'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('password')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-floating mb-3">
                          <select name="role_id" id="edit-role_id" class="form-select" required>

                            @foreach ($roles as $role)
                                <option value="{{$role->id}}"> {{$role->nom}}</option>
                            @endforeach
                          </select>
                            <label for="edit-role_id">Rôle</label>
                            @if ($errors->has('role_id'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('role_id')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <div class="form-floating mb-3">
                          <select name="client_id" id="edit-client_id" class="form-select" required>
                            <option value=""></option>
                            @foreach ($clients as $client)
                                <option value="{{$client->id}}"> {{$client->raison_sociale}}</option>
                            @endforeach
                          </select>
                            <label for="edit-client_id">Client</label>
                            @if ($errors->has('client_id'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('client_id')}}</strong> 
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-check form-checkbox-secondary mb-3">
                            <label class="form-check-label" for="edit-mail">Envoyer un mail de réinitialisation du mot de passe</label>
                            <input type="checkbox" name="mail" id="edit-mail" class="form-check-input ">
                            @if ($errors->has('mail'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('mail')}}</strong> 
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

{{-- Modification d'un utilisateur --}}
<script>

$('.edit-utilisateur').click(function (e) {

        let that = $(this);
        let currentNom = that.data('nom');
        let currentPrenom = that.data('prenom');
        let currentEmail = that.data('email');

        let currentClientId = that.data('client_id');
        let currentRoleId = that.data('role_id');

    
        let currentFormAction = that.data('href');
        $('#edit-nom').val(currentNom) ;
        $('#edit-prenom').val(currentPrenom) ;
        $('#edit-email').val(currentEmail) ;
        $('#edit-client_id option[value='+currentClientId+']').attr("selected",true);
        $('#edit-role_id option[value='+currentRoleId+']').attr("selected",true);
        $('#form-edit').attr('action', currentFormAction) ;

})

</script>


<script>
    $(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
        $('[data-toggle="tooltip"]').tooltip()
        $('body').on('click','a.archive-utilisateur',function(event) {
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
        $('body').on('click','a.unarchive-utilisateur',function(event) {
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
                        // url:"/utilisateur/desarchiver/2",
                        
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

