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
                        <li class="breadcrumb-item"><a href="{{route('article.index')}}">Article</a></li>
                        <li class="breadcrumb-item active">Ajouter</li>
                    </ol>
                </div>
                <h4 class="page-title">Créer un nouvel article</h4>
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

                    <form action="{{route('article.store')}}" method="post" class="dropzone" id="drop" data-plugin="dropzone" data-previews-container="#file-previews"
                        data-upload-preview-template="#uploadPreviewTemplate">

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
                                                    <label for="titre" class="form-label">Titre</label>
                                                    <input type="text" class="form-control" name="titre" value="{{old('titre')}} " id="titre"  required>
                                                    @if ($errors->has('titre'))
                                                      <br>
                                                        <div class="alert alert-danger" role="alert">
                                                            <i class="dripicons-wrong me-2"></i> <strong>{{$errors->first('titre')}}</strong> 
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <textarea rows="50" name="contenu">
                                             
                                                </textarea>
                                            </div>
                                        </div>


                                        <div class="col-4">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="categorie_id" class="form-label">Catégorie</label>
                                                    <select name="categorie_id" id="categorie_id"  class="form-select" >                                                    
                                                        
                                                        @foreach ($categories as $categorie)                                                        
                                                            <option value="{{$categorie->id}}">{{$categorie->nom}}</option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                            </div>

                                            <div class="col-12" >
                                                <label for="images" class="form-label">Image(s)</label>

                                                <div class="fallback" >
                                                    <input name="images" type="file"   multiple />
                                                </div>
                                            
                                                <div class="dz-message needsclick"   style="border:dashed rgb(121, 119, 119);">
                                                    <i class="h1 text-muted dripicons-cloud-upload"></i>
                                                    <h3>Déposez les images ici ou cliquez pour les télécharger.</h3>
                                                    <span class="text-muted font-13">(<strong>Les images s'ajouteront de façon aléatoire sur les sites</strong>)</span>
                                                </div>


                                                                                                
                                                <!-- Preview -->
                                                <div class="dropzone-previews mt-3" id="file-previews"></div>

                                                <!-- file preview template -->
                                                <div class="d-none" id="uploadPreviewTemplate">
                                                    <div class="card mt-1 mb-0 shadow-none border">
                                                        <div class="p-2">
                                                            <div class="row align-items-center">
                                                                <div class="col-auto">
                                                                    <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                                                                </div>
                                                                <div class="col ps-0">
                                                                    <a href="javascript:void(0);" class="text-muted fw-bold" data-dz-name></a>
                                                                    <p class="mb-0" data-dz-size></p>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <!-- Button -->
                                                                    <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                                                        <i class="dripicons-cross"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                                                        
                            </div>
                            <div class="modal-footer">
                                <a  class="btn btn-light" href="{{route('article.index')}}">Annuler</a>
                                <button type="submit" class="btn btn-success">Enregistrer</button>
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
<script src={{asset("assets/js/vendor/dropzone.min.js")}}></script>
<!-- init js -->
<script src={{asset("assets/js/ui/component.fileupload.js")}}></script>

<script>
// Dropzone.options.drop = {
//     acceptedFiles: 'image/*'
// };
Dropzone.options.drop = { // camelized version of the `id`
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 2, // MB
    acceptedFiles: 'image/*',
    accept: function(file, done) {
      if (file.name != "justinbieber.jpg") {
        done("Naha, you don't.");
        console.log("ddddddddddd");
      }
      else { console.log("errrrr"); done(); }
    }
  };

</script>
<script src="https://cdn.tiny.cloud/1/ieugu2pgq0vkrn7vrhnp69zprqpp5xfwh9iewe7v24gtdj8f/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
  </script>
@endsection