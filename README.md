Generador de Anejo de fotografías
Este proyecto proporciona una API que genera fotografías y un documento Word.
Instalación y configuración
Este proyecto es una aplicación web desarrollada con PHP, Laravel y MySql
Requisitos
Asegúrate de tener los siguientes requisitos antes de ejecutar el proyecto:
•	Xammp
Pasos
Sigue estos pasos para configurar y ejecutar el proyecto:
1.	Clona el repositorio desde: Git: https://github.com/ElizMartinez/Proyecto_Generador_fotos.git
2.	Ejecuta el comando composer install para instalar las dependencias del proyecto.
3.	Ejecuta el comando  composer self-update para actualizar la ultima versión.
4.	Crea el archivo .env  con el siguiente comando  copy NUL .env a partir del archivo .env.example y configura las variables de entorno según tu entorno de desarrollo.
5.	Ejecuta el comando composer update
6.	Ejecuta el comando php artisan key:generate para generar la llave del proyecto.
7.	Ejecuta nuevamente el comando composer update
8.	Ejecuta los siguientes comandos:
composer require laravel/Passport 
php artisan passport:install
9.	 Ejecuta nuevamente el comando composer update.
10.	Crear las siguientes carpeta llamada foto y una llamada word en la carpeta llamada app/public.
11.	Abrir la consola Simbolo de sistema y ejecutar como administrador el siguiente comando 
icacls "C:\Users\user\Desktop\Artificial\Proyecto_Generador_fotos\Proyecto_Generador_de_fotos\storage\app\public" /grant "IIS_IUSRS:(OI)(CI)F"
12.	Para agregar el nombre de un usuario nuevo el siguiente comando 
php Artisan passport:client  --personal
