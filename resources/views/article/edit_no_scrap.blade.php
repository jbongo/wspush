@extends('layouts.app')
@section('css')

<link href="{{asset("assets/css/dropzone.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("assets/css/dropzone-custom.css")}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="content">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0"> 
                        <li class="breadcrumb-item"><a href="{{route('article.index')}}">Article</a></li>
                        <li class="breadcrumb-item active">Ajouter</li>
                    </ol>
                </div>
                <h4 class="page-title">Modification & Publication de l'article</h4>
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
                            <a href="{{route('article.index')}}" type="button" class="btn btn-outline-primary"><i class="uil-arrow-left"></i> Retour</a>
                        </div>
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
    <!-- end row-->
    <div class="row">

  

        <div class="col-12 ">
            <div class="card">
                <div class="card-body">
                   

{{--                        
                            <div class="row">

                                <div class="row justify-content-between">
                                <div class="col-4">
                                    <span class="" style="font-style: italic"><a href="{{ $article->url}}" target="_blank">Voir l'article original</a> </span>
                                </div>
                                <div class="col-4">
                                    @if($article->est_publie == false)
                                        <a href="{{route('article.publier', Crypt::encrypt($article->id))}}" type="button"
                                            class="btn btn-danger" ><i class="uil-plus"></i> Publier</a>
                                    @else
                                        <a href="" type="button"
                                            class="btn btn-secondary" ><i class="uil-plus"></i> Publié</a>
                                    @endif
                                </div>
                            </div> --}}
                          
                            

                           
                        </div>

                    <form action="{{route('article.update', Crypt::encrypt($article->id))}}" method="post"  enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                {{-- <h4 class="modal-title" id="">Modifier l'article</h4> --}}
                                <br>
                          
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <br>
                           

                                    @csrf
                                    

                                    <div class="row">
                                        <div class="col-8">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="titre" class="form-label">Titre *</label>
                                                    <input type="text" class="form-control" name="titre" value="{{old('titre') ? old('titre') : $article->titre }} " id="titre"  required>
                                                    @if ($errors->has('titre'))
                                                      <br>
                                                        <div class="alert alert-danger" role="alert">
                                                            <i class="dripicons-wrong me-2"></i> <strong>{{$errors->first('titre')}}</strong> 
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="titre" class="form-label">Contenu  *</label>

                                                <textarea rows="50" name="contenu" required>
                                                    {{old('contenu') ? old('contenu') : $article->description }}
                                                </textarea>
                                            </div>
                                        </div>


                                        <div class="col-4">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="categorie_id" class="form-label">Catégorie *</label>
                                                    <select name="categorie_id" id="categorie_id"  class="form-select" required>                                                    
                                                        <option value="{{$article->categoriearticle->id}}">{{$article->categoriearticle->nom}}</option>
                                                        @foreach ($categories as $categorie)                                                        
                                                            <option value="{{$categorie->id}}">{{$categorie->nom}}</option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="langue_id" class="form-label">Langue de l'article *</label>
                                                    <select name="langue_id" id="langue_id"  class="form-select" required >                                                    
                                                        <option value="{{$article->langue->id}}">{{$article->langue->nom}}</option>
                                                    
                                                        @foreach ($langues as $langue)                                                        
                                                            <option value="{{$langue->id}}">{{$langue->nom}}</option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                            </div>

                                            <div class="col-12" >
                                                <label for="images" class="form-label">Ajouter Image(s)</label>

                                                <div class="fallback" >
                                                    <input name="images[]" class=" btn btn-danger image-multiple" accept="image/*" type="file"   multiple />
                                                </div>
                                                     
                                            </div>

                           
                                            
                                            <hr>

                                            <div class="row" >
                                                <div class="col-md-12 col-lg-12" id="liste_photo_visible" >          
                                                    
                                                
                                                        <ul id="sortable_visible">
                                                            @foreach($article->images as $image )
                                                          
                                                                <div class="col-lg-3 col-md-3" id="{{$image->id}}"> 
                                                                    <div style="margin: auto; width:70%; border: 1px solid white; padding-bottom: 50px; cursor: move;">
                                                                        <li ><span class="badge badge-info "></span><p><img src="{{asset('/images-articles//'.$image->filename)}}" alt="" width="100%" height="70px"></p></li>
                                                                        <p style="border: 3px solid green; text-align:center">
                                                                            <a  class="delete" data-href="{{route('article.destroy_image',$image->id)}}" style="cursor: pointer;" data-toggle="tooltip" title="@lang('Supprimer cette image')"><i class=" uil-trash-alt"></i> </a>
                                                                            <a href="{{route('article.get_image',Crypt::encrypt($image->id))}}"  data-toggle="tooltip"  title="@lang('Télécharger cette image')" > <i class=" uil-image-download "></i> </a>
                                                                        </p>                                
                                                                    </div>
                                                                </div>
                                                                
                                                            @endforeach
                                                            
                                                        </ul>    
                                             
                                                            
                                                </div>
                                        

                                            </div>
                                            
                                        </div>
                                    </div>
                                                                        
                            </div>
                            <div class="modal-footer"  style="position: fixed;bottom: 10px; margin: 0;  left: 50%; z-index:1 ;" >
                                <a  class="btn btn-light btn-lg " href="{{route('article.index')}}">Annuler</a>
                                <button type="submit" class="btn btn-warning btn-flat btn-addon btn-lg ">Modifier</button>
                            </div>
                        </div>
                    </form> 
           
                </div>
            </div>
        </div> <!-- end col -->
        
        
        
        
    </div> <!-- end row -->
    
<style>
    .container{
        display: flex;
        
        flex-flow: row wrap;
        gap: 20px;
    
    }
</style>   

    
</div> <!-- End Content -->


@endsection

@section('script')


<script src="https://cdn.tiny.cloud/1/ieugu2pgq0vkrn7vrhnp69zprqpp5xfwh9iewe7v24gtdj8f/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<script src="{{ asset('assets/js/sweetalert2.all.js')}}"></script>

<script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
</script>

  
<script>



        //@@@@@@@@@@@@@@@@@@@@@ SUPPRESSION DES PHOTOS DU BIEN @@@@@@@@@@@@@@@@@@@@@@@@@@
   
   $( document ).ready(function() {
    
    $(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
        $('[data-toggle="tooltip"]').tooltip()
        $('.delete').on('click',function(e) {
            let that = $(this)
            e.preventDefault()

            const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
})

swalWithBootstrapButtons.fire({
  title: "Supprimer l'image ?",
  text: "",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Oui',
  cancelButtonText: 'Non',
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
        $.ajax({                        
            url: that.attr('data-href'),
            type: 'GET'
        })
        .done(function () {
                // that.parents('tr').remove()
                that.parent().parent().parent().remove();

        })

        swalWithBootstrapButtons(
            'Supprimé!',
            'image supprimée.',
            'success'
            )
            
            
        } else if (
            result.dismiss === swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons(
            'Annulé',
            'Cette image n\'a pas été supprimée :)',
            'error'
            )
        }
})

return 0

        })
    })
    
    });
     //@@@@@@@@@@@@@@@@@@@@@ FIN @@@@@@@@@@@@@@@@@@@@@@@@@@
</script>
@endsection