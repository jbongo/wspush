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
                        <li class="breadcrumb-item"><a href="{{route('action.index')}}">Titres</a></li>
                        <li class="breadcrumb-item active">Détails</li>
                    </ol>
                </div>
                <h4 class="page-title">{{$action->nom}}</h4>
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
                            <a href="{{route('action.index')}}" type="button" class="btn btn-outline-secondary"><i class="uil-arrow-left"></i> Retour</a>
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
                   
                    <form action="{{route('action.update', Crypt::encrypt($action->id))}}" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="addActionModalLabel">Modifier le titre</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="nom" class="form-label">Nom</label>
                                                <input type="text" class="form-control" name="nom" value="{{old('nom') ? old('nom') : $action->nom}}" id="nom"  required>
                                                @if ($errors->has('nom'))
                                                  <br>
                                                    <div class="alert alert-danger" role="alert">
                                                        <i class="dripicons-wrong me-2"></i> <strong>{{$errors->first('nom')}}</strong> 
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label for="url" class="form-label">Url</label>
                                                <input type="url" class="form-control" name="url" value="{{old('url') ? old('url') : $action->url}}" id="url" required >
                                                @if ($errors->has('url'))
                                                  <br>
                                                    <div class="alert alert-danger" role="alert">
                                                        <i class="dripicons-wrong me-2"></i> <strong>{{$errors->first('url')}}</strong> 
                                                    </div>
                                                @endif
                                            </div>  
                                          
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="seuil_pourcentage" class="form-label">Seuil en pourcentage ?</label>
                                                <select name="seuil_pourcentage" id="seuil_pourcentage"  class="form-control" >
                                                    <option value="">{{$parametre->seuil_pourcentage == true ? "oui" : "non"}}</option>
                                                    <option value="oui">oui</option>
                                                    <option value="nom">nom</option>
                                                </select>
                                            </div> 
                                            {{-- <div class="mb-3">
                                                <label for="seuil_alerte" class="form-label">Seuil d'alerte (%)</label>
                                                <input type="number" min="0" max="100" step="0.001" class="form-control" name="seuil_alerte" value="{{old('seuil_alerte') ? old('seuil_alerte') : $action->seuil_alerte}}" id="seuil_alerte" required >
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="heure_delais_achat" class="form-label">Délais heure d'achat</label>
                                                <input type="time" min="09:00" max="17:30"  class="form-control" name="heure_delais_achat" value="{{old('heure_delais_achat') ? old('heure_delais_achat') : $action->heure_delais_achat}}" id="heure_delais_achat"  >
                                            </div> --}}
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            
                                            
                                            <div class="row">
                                                <label class="col-lg-3 col-form-label" for="check_palier_starter">Paliers<span class="text-danger">*</span></label>
                                            </div>
    
                                            <div class="col-lg-12 col-md-12 col-sm-12" id="palier_starter">
                                                
                                                    
                                                <div class="input_fields_wrap">
                                                    <a class="btn btn-warning add_field_button" style="margin-left: 53px;">Ajouter un niveau</a>
                                                 
                                                   
                                                    @foreach ($paliers as $palier)
                                                        
                                                        @php
                                                      
                                                            $niveau=$palier[0] ;
                                                            $seuil_achat=$palier[1] ;
                                                            $seuil_vente=$palier[2] ;
                                                            $quantite=$palier[3] ;
                                                          
                                                            $x=$niveau;
                                                            // dd($niveau.'-'.$seuil_achat.'-'.$seuil_vente.'-'.$quantite);
                                                        @endphp
                                                        <div class="container field{{$niveau}}">
                                                            <div class="item">
                                                                <label for="niveau{{$niveau}}">Niveau: </label>
                                                                <input class="form-control" type="text" value="{{$niveau}}" id="niveau{{$niveau}}" name="niveau{{$niveau}}" readonly>
                                                            </div>
                                                            <div class="item">
                                                                <label for="seuil_achat{{$niveau}}">Seuil achat : </label>
                                                                <input class="form-control" type="number" min="0"  step="0.001" value="{{$seuil_achat}}" id="seuil_achat{{$niveau}}" required name="seuil_achat{{$niveau}}" >
                                                            </div>
                                                            <div class="item">
                                                                <label for="seuil_vente{{$niveau}}">Seuil vente : </label>
                                                                <input class="form-control" type="number"  min="0"  step="0.001" value="{{$seuil_vente}}" id="seuil_vente{{$niveau}}" required name="seuil_vente{{$niveau}}"  >
                                                            </div>
                                                            <div class="item">
                                                                <label for="quantite{{$niveau}}">Quantité : </label>
                                                                <input class="form-control" type="number" min="0" value="{{$quantite}}" id="quantite{{$niveau}}" required name="quantite{{$niveau}}" />
                                                            </div>
                                                            @if ($niveau > 1 )
                                                                <button href="#" id="palier_remove{{$niveau}}" style="font-size:10px; font-weight:bold" class="btn btn-danger remove_field">X</button></br>
                                                            @else
                                                                <button href="#" id="palier_remove{{$niveau}}" style="font-size:10px; font-weight:bold" class="btn btn-danger cacher_btn_remove_field remove_field">X</button></br>
                                                            @endif
                                                            
                                                        </div>
                                                    @endforeach

                                                </div>
                                                    
                                            </div>
                                        </div>            
                                </div>
                                                                        
                            </div>
                            <div class="modal-footer">
                                <a  class="btn btn-light" href="{{route('action.index')}}">Annuler</a>
                                <button type="submit" class="btn btn-success">Modifier</button>
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

<script>
    var x = "{{$x}}";

    $(".cacher_btn_remove_field").hide();
    $(document).ready(function() {
        var max_fields = 10;
        var wrapper = $(".input_fields_wrap");
        var add_button = $(".add_field_button");
      
        $(add_button).click(function(e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                
                $(wrapper).append(`
                <div class="container field${x}">
                    <div class="item">
                        <label for="niveau${x}">Niveau: </label>
                        <input class="form-control" type="text" value="${x}" id="niveau${x}" name="niveau${x}" readonly>
                    </div>
                    <div class="item">
                        <label for="seuil_achat${x}">Seuil achat : </label>
                        <input class="form-control" type="number" min="0"  step="0.001" value="" id="seuil_achat${x}" required name="seuil_achat${x}" >
                    </div>
                    <div class="item">
                        <label for="seuil_vente${x}">Seuil vente : </label>
                        <input class="form-control" type="number" min="0" step="0.001" value="" id="seuil_vente${x}" required name="seuil_vente${x}"  >
                    </div>
                    <div class="item">
                        <label for="quantite${x}">Quantité : </label>
                        <input class="form-control" type="number" min="0" value="" id="quantite${x}" required name="quantite${x}" />
                    </div>
                    <button href="#" id="pal_starter' + x + '"  style="font-size:10px; font-weight:bold" class="btn btn-danger btn-xs remove_field">X</button></br>
                    
                </div>
                
                `); 
              
            }
        });
        $(wrapper).on("click", ".remove_field", function(e) {
            e.preventDefault();
            if (x > 2) $("#pal_starter" + (x - 1) + '').show();
            $(this).parent('div').remove();
            x--;
        })
    });

</script>
@endsection