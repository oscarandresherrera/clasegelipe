<!-- index.php -->
<?php
// Incluir el archivo de la cabecera
include('header.php');

// Verificar qué página solicitará el usuario
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 'home'; // Si no hay 'page', cargar 'home' por defecto

// Incluir la página correspondiente
switch ($page) {
    case 'home':
        include('home.php');
        break;
    case 'about':
        include('about.php');
        break;
    case 'services':
        include('services.php');
        break;
    case 'contact':
        include('contact.php');
        break;
    default:
        include('home.php');
        break;
}

// Incluir el archivo de pie de página
include('footer.php');
?>
