@component('mail::message')
# Bonjour 

@component('mail::panel')
    
    <span style="font-weight: bold; color:#ff0b0b;" > {{$action->nom}} </span> <br><br>    
    <span style="font-weight: bold;"> Quantité à acheter:  <span style="color:#0000ff" >{{$quantite}}</span>  </span><br> <br>
    <span style="font-weight: bold;"> Valeur actuelle:  <span style="color:#0000ff" >{{$valeur_action}} €</span> </span><br>
    <span style="font-weight: bold;"> Valeur à partir de laquelle il faut acheter:  <span style="color:#0000ff" >{{$seuil_reference - $alerte->seuil_achat}} €</span></span>
    <span style="font-weight: bold;"> Seuil de référence:  <span style="color:#0000ff" >{{$seuil_reference}} €</span> </span><br>

@endcomponent

@component('mail::button', ['url' => route('alerte.show', Crypt::encrypt($alerte->id)) ])
Détails
@endcomponent

@endcomponent