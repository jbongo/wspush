@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/dropzone.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/dropzone-custom.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('assets/dist/css/bootstrap-select.css') }}">

    <style>
        /* custom titres select */
        .dropdown-header {

            font-weight: bold;
            color: #172f43;

        }

        .container {
            display: flex;
            justify-content: flex-end;

        }

        .item {
            /* flex:1; */
            margin: 10px;
            padding: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('article.index') }}">Article</a></li>
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
                                <a href="{{ route('article.index') }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i> Retour</a>
                            </div>
                            @if (session('ok'))
                                <div class="col-6">
                                    <div class="alert alert-success alert-dismissible bg-success text-white text-center border-0 fade show"
                                        role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong> {{ session('ok') }}</strong>
                                    </div>
                                </div>
                            @endif
                            @if (session('nok'))
                                <div class="col-6">
                                    <div class="alert alert-warning alert-dismissible bg-warning text-white text-center border-0 fade show"
                                        role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong> {{ session('ok') }}</strong>
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

                            <div class="row justify-content-between">
                                <div class="col-3">
                                    <span class="" style="font-style: italic"><a href="{{ $article->url }}"
                                            target="_blank">Voir l'article original</a> </span>
                                </div>


                                <div class="col-9">

                                    <div class="container">
                                        <div class="item">
                                         
                                            <a data-href="{{ route('article.publier_article_interne', Crypt::encrypt($article->id)) }}" 
                                                type="button" class="btn btn-danger publier"><i class=" uil-bolt-alt "></i>
                                                @if($article->est_publie == true) Re-Publier @else Publier @endif Sur
                                            </a>
                                    
                                        </div>

                                        <div class="item">

                                            <select class="form-select btn-light" id="publier_sur" name="publier_sur">


                                                <option value="allsite" @if($article->est_publie_tous_site == true ) selected @endif>
                                                    Tous les sites en {{ $article->langue->nom }}
                                                </option>
                                                <option value="selectsite" @if($article->est_publie_tous_site == false ) selected @endif >Sélectionner les sites</option>
                                            </select>
                                        </div>
                                        <div class="item ">

                                            <div class=" choix_sites ">
                                                <select id="siteinternes" name="siteinternes[]" class="selectpicker selectpicker2"
                                                    data-style="btn-warning" data-live-search="true" multiple>
                                                    <option value="decoche" style="color:red"> Tout décocher</option>
                                                    <option value="all" class="option_all" selected>Tous les sites </option>

                                                    @foreach ($pays as $pay)
                                                        @if (sizeof($pay->siteinternesClient) > 0)
                                                            <optgroup style="font-weight: bold"
                                                                label="{{ $pay->nom }}">
                                                                @foreach ($pay->siteinternesClient as $siteinterne)
                                                                    <option class="option_si" value="{{$siteinterne->id}}"
                                                                        data-tokens="{{ $siteinterne->nom }} {{ $pay->nom }}">
                                                                        {{ $siteinterne->nom }}</option>
                                                                @endforeach
                                                        @endif
                                                    @endforeach

                                                    </optgroup>

                                                </select>
                                            </div>
                                        </div>





                                    </div>
                                </div>



                            </div>
                        </div>



                    </div>

                    <form action="{{ route('article.update', Crypt::encrypt($article->id)) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                {{-- <h4 class="modal-title" id="">Modifier l'article</h4> --}}
                                <br>

                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <br>


                                @csrf


                                <div class="row">
                                    <div class="col-8">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="titre" class="form-label">Titre *</label>
                                                <input type="text" class="form-control" name="titre"
                                                    value="{{ old('titre') ? old('titre') : $article->titre }} "
                                                    id="titre" required>
                                                @if ($errors->has('titre'))
                                                    <br>
                                                    <div class="alert alert-danger" role="alert">
                                                        <i class="dripicons-wrong me-2"></i>
                                                        <strong>{{ $errors->first('titre') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="titre" class="form-label">Contenu *</label>

                                            <textarea rows="50" name="contenu" required>
                                                    {{ old('contenu') ? old('contenu') : $article->description }}
                                                </textarea>
                                        </div>
                                    </div>


                                    <div class="col-4">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="categorie_id" class="form-label">Catégorie *</label>
                                                <select name="categorie_id" id="categorie_id" class="form-select"
                                                    required>
                                                    <option value="{{ $article->categoriearticle->id }}">
                                                        {{ $article->categoriearticle->nom }}</option>
                                                    @foreach ($categories as $categorie)
                                                        <option value="{{ $categorie->id }}">{{ $categorie->nom }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="langue_id" class="form-label">Langue de l'article *</label>
                                                <select name="langue_id" id="langue_id" class="form-select" required>
                                                    <option value="{{ $article->langue->id }}">
                                                        {{ $article->langue->nom }}</option>
                                                    @foreach ($langues as $langue)
                                                        <option value="{{ $langue->id }}">{{ $langue->nom }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="images" class="form-label">Ajouter Image(s)</label>

                                            <div class="fallback">
                                                <input name="images[]" class=" btn btn-danger image-multiple"
                                                    accept="image/*" type="file" multiple />
                                            </div>

                                        </div>



                                        <hr>

                                        <div class="row">
                                            <div class="col-md-12 col-lg-12" id="liste_photo_visible">


                                                <ul id="sortable_visible" class="container-image">
                                                    @foreach ($article->images as $image)
                                                        <div class="col-lg-4 col-md-4" id="{{ $image->id }}">
                                                            <div
                                                                style="margin: auto; width:70%; border: 1px solid white; padding-bottom: 50px; cursor: move;">
                                                            
                                                                    <p><img src="{{$image->filename}}"
                                                                            alt="" width="100%" height="70px">
                                                                    </p>
                                                               
                                                                <p style="border: 3px solid green; text-align:center">
                                                                    <a class="delete"
                                                                        data-href="{{ route('article.destroy_image', $image->id) }}"
                                                                        style="cursor: pointer;" data-toggle="tooltip"
                                                                        title="@lang('Supprimer cette image')"><i
                                                                            class=" uil-trash-alt"></i> </a>
                                                                    <a href="{{ route('article.get_image', Crypt::encrypt($image->id)) }}"
                                                                        data-toggle="tooltip" title="@lang('Télécharger cette image')">
                                                                        <i class=" uil-image-download "></i> </a>
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
                            <div class="modal-footer"
                                style="position: fixed;bottom: 10px; margin: 0;  left: 50%; z-index:1 ;">
                                <a class="btn btn-light btn-lg " href="{{ route('article.index') }}">Annuler</a>
                                <button type="submit"
                                    class="btn btn-warning btn-flat btn-addon btn-lg ">Modifier</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div> <!-- end col -->




    </div> <!-- end row -->

    <style>
        .container {
            display: flex;

            flex-flow: row wrap;
            gap: 20px;

        }
        .container-image{
            display: flex;

            flex-flow: row wrap;
            gap: 20px;

        }
    </style>


    </div> <!-- End Content -->
@endsection

@section('script')
    <!-- Latest compiled and minified JavaScript -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>


    <script src="https://cdn.tiny.cloud/1/ieugu2pgq0vkrn7vrhnp69zprqpp5xfwh9iewe7v24gtdj8f/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>

    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>

<script>
    //   Selection des sites 
    var allSite = "{{$article->est_publie_tous_site}}";

    if(allSite == 0){
        $('.choix_sites').show();
    }else{
        $('.choix_sites').hide();

    }

        $('#publier_sur').change(function(e) {

            if (e.currentTarget.value == "allsite") {
                $('.choix_sites').hide();

            } else {
                $('.choix_sites').show();


            }
        })

</script>

<script>
    //@@@@@@@@@@@@@@@@@@@@@ PUBLICATION DE L'ARTICLE  @@@@@@@@@@@@@@@@@@@@@@@@@@




    
//   Selection des sites 


        // On determine si l'article est publié sur tous les sites 


     


        var allVal = "{{$allVal}}";
        allVal = allVal.replaceAll("&quot;", '"');
        allVal = JSON.parse(allVal);

      
        var selectedVal = "{{$siteSelected}}";
        selectedVal = selectedVal.replaceAll("&quot;", '"');        
        selectedVal = JSON.parse(selectedVal);        

        var val =  selectedVal; 

        $('.selectpicker2').selectpicker('val', selectedVal);
      

        $('.selectpicker').selectpicker();

        $('#siteinternes').change(function(e) {            
            
            val =  $('#siteinternes').val();

            if ( val.includes('decoche')) {
                $('.selectpicker2').selectpicker('deselectAll');
            }
            
            else if ( val.includes('all')) {
        
                $('.selectpicker2').selectpicker('val', allVal);

            }

        });

    $(document).ready(function() {

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('.publier').on('click', function(e) {
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
                    title: "Publier l'article ?",
                    text: "",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: true
                }).then((result) => {  
                    if (result.isConfirmed) {
                        var data = {
                            "publier_sur" : $('#publier_sur').val(),
                            "siteinternes" : val,
                        }
                        $.ajax({
                                url: that.attr('data-href'),
                                data: data,
                                type: 'GET'
                            })
                            .done(function(data) {
                              
                                console.log(data);                                          

                            })

                            Swal.fire(
                                'Article publié!',
                                '',
                                'success'
                            )
                            .then(function() {
                                location.reload(true)
                            })
                        // swalWithBootstrapButtons.fire(
                        //     'Publié!',
                        //     'Article publié.',
                        //     'success'
                        // )


                    } else if (
                        result.dismiss === swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulé',
                            'Article non publié :)',
                            'error'
                        )
                    }
                })

        

            })
        })

    });
    //@@@@@@@@@@@@@@@@@@@@@ FIN @@@@@@@@@@@@@@@@@@@@@@@@@@
</script>

    <script>
        //@@@@@@@@@@@@@@@@@@@@@ SUPPRESSION DES PHOTOS DE L'ARTICLE @@@@@@@@@@@@@@@@@@@@@@@@@@

        $(document).ready(function() {

            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $('[data-toggle="tooltip"]').tooltip()
                $('.delete').on('click', function(e) {
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
                                .done(function() {
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
