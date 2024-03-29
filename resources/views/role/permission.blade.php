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
                           <li class="breadcrumb-item"><a href="javascript: void(0);">Rôle</a></li>
                           <li class="breadcrumb-item"><a href="javascript: void(0);">Permissions</a></li>
                           <li class="breadcrumb-item active">Rôles</li>
                       </ol>
                   </div>
                   <h4 class="page-title">Rôles</h4>
               </div>
           </div>s
       </div>
       <!-- end page title --> 

       <div class="row">
           <div class="col-12">
               <div class="card">
                   <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <a href="javascript:void(0);" class="btn btn-primary mb-2"  data-bs-toggle="modal" data-bs-target="#standard-modal"><i class="mdi mdi-plus-circle me-2"></i> Nouveau rôle</a>
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
                            @if ($errors->has('role'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('role')}}</strong> 
                                </div>
                            @endif
                            <div  id="div-role-message" class="alert alert-success text-secondary alert-dismissible fade in">
                                <i class="dripicons-checkmark me-2"></i>
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <a href="#" class="alert-link"><strong> <span id="role-message"></span></strong></a> 
                            </div>

                        </div>
                    </div>
                   
                       <div class="table-responsive">
                           <table class="table table-centered table-borderless table-hover w-100 dt-responsive nowrap" id="products-datatable">
                               <thead class="table-light">
                                   <tr>
                                  
                                       <th>Permissions</th>
                                                                         

                                       <th style="width: 125px;">Action</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   @foreach ($permissionsGroups as $group)
                                       
                                        <tr>
                                            <td>{{$group->nom}}</td>
                                        </tr>
                                        @foreach ($group->permissions as $permission)
                                        <tr>
                                            
                                            <td><a href="#" class="text-body fw-bold">{{$permission->nom}}</a> </td>
                                            <td>
                                                <input type="checkbox" name="" id="" checked>
                                            </td>
                                    
                                        </tr>
                                        @endforeach
                                    
                                   @endforeach
                                   
                               </tbody>
                           </table>
                       </div>
                   </div> <!-- end card-body-->
               </div> <!-- end card-->
           </div> <!-- end col -->
       </div>
       <!-- end row -->  
        
    </div> <!-- End Content -->

    {{-- Ajout d'un rôle --}}
    <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Ajouter un rôle</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{route('role.store')}}" method="post">
                <div class="modal-body">
                
                    @csrf
                    <div class="col-lg-12">
                        
                        <div class="form-floating mb-3">
                            <input type="text" name="role" value="{{old('role') ? old('role') : ''}}" class="form-control" id="floatingInput" >
                            <label for="floatingInput">Rôle</label>
                            @if ($errors->has('role'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('role')}}</strong> 
                                </div>
                            @endif
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


     {{-- Modification d'un rôle --}}
     <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Modifier le rôle</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="" method="post" id="form-edit">
                <div class="modal-body">
                
                    @csrf
                    <div class="col-lg-12">
                        
                        <div class="form-floating mb-3">
                            <input type="text" name="role" value="{{old('role') ? old('role') : ''}}" class="form-control" id="edit-role" >
                            <label for="edit-role">Rôle</label>
                            @if ($errors->has('role'))
                                <br>
                                <div class="alert alert-warning text-secondary " role="alert">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>{{$errors->first('role')}}</strong> 
                                </div>
                            @endif
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


@endsection

@section('js')

{{-- Modification d'un rôle --}}
<script>

$('.edit-role').click(function (e) {

        let that = $(this);
        let currentRole = that.data('value');
        let currentFormAction = that.data('href');
        $('#edit-role').val(currentRole) ;
        $('#form-edit').attr('action', currentFormAction) ;

})

</script>


<script>
    $(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
        $('[data-toggle="tooltip"]').tooltip()
        $('body').on('click','a.archive-role',function(event) {
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
                'Rôle non archivé :)',
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
        $('body').on('click','a.unarchive-role',function(event) {
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
                        // url:"/role/desarchiver/2",
                        
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
                'Rôle non désarchivé :)',
                'error'
                )
            }
            }); 
            })

    });
   

</script>
@endsection
{{-- @include('layouts.footer') --}}
