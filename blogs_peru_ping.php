<?php
/*
Plugin Name: Blogs Peru Ping
Plugin URI: http://myspace.wihe.net/blogs-peru-ping/
Description: Envia pings de manera autom&aacute;tica hacia <a href="http://www.blogsperu.com">Blogs Per&uacute;</a>, cada vez que publiques una nueva entrada.
Author: Willy Henostroza
Version: 1.0
Author URI: http://myspace.wihe.net/
*/

/*
IMPORTANTE:
Favor de leer el archivo "leeme.txt", antes de proseguir.
*/

if(!defined("ABSPATH"))
{
 	die("Intento de Hacking");
}

/* Inicio de Configuraciones */

// ID de Auto-Ping
$id = "";

/* Fin de Configuraciones */

/* 
   De aqui en adelante, no se necesita que modifiques nada mas,
   a menos que tengas conocimiento sobre programacion en PHP 
   y/o manejo de sockets en PHP.
*/

function blogs_peru_ping($post_ID)
{
	// Obteniendo Configuraciones
	global $id;
	
	// Creacion e Inicio de una conexion hacia www.blogsperu.com
	$conexion = fsockopen("www.blogsperu.com", 80, $errno, $errstr, 30);
	
  if(!$conexion)
  {
    // Reporte de error conexion
    add_action("admin_head", print("<center><b>ERROR $errno</b>: $errstr</center>"));
  }
  else
  {	 
	  // Generando la cabecera HTTP a enviar atraves de la conexion previamente establecida
    $cabecera = "GET /ping/auto.asp?id=$id HTTP/1.1\r\n";
    $cabecera .= "Host: www.blogsperu.com\r\n";
    $cabecera .= "User-Agent: Blogs Peru Ping 1.0 (WordPress Plugin)\r\n";   
    $cabecera .= "Connection: Close\r\n\r\n";

    // Envio de la cabecera generada atravez de la conexion previamente establecida
    fwrite($conexion, $cabecera);
    
    // Cerrando la conexion previamente establecida
    fclose($conexion); 
  }
}

// Añade este plugin cuando se publique y/o edite una nueva entrada
add_action('publish_post', 'blogs_peru_ping');
?>