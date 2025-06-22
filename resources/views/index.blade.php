
@extends('layouts.layout')

@section('title', 'Gestion de Fincas')

@section('content')
<style>
    .background {
        /* background-image: url('ruta/a/tu/imagen.jpg'); Cambia esto por la ruta de tu imagen */
        background-size: cover; /* Asegura que la imagen cubra todo el contenedor */
        background-position: center; /* Centra la imagen */
        height: 100vh; /* Altura completa de la ventana */
        display: flex; /* Usamos flexbox para centrar el contenido */
        justify-content: center; /* Centra horizontalmente */
        align-items: center; /* Centra verticalmente */
        color: white; /* Cambia el color del texto si es necesario */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Sombra para mejorar la visibilidad del texto */
    }
</style>

<div class="background">
    <h1>FINCA: LA FORTALEZA DEL PADRE</h1>
</div>
@endsection
