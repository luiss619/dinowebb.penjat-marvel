<h1>Penjat Edició Marvel</h1>

<p align="center">
    <b>Características</b><br>
    PHP +8.0 | Bootstrap 5 | Jquery 3.6 | Font awesome 6.1 | Animate 4.11
</p>

## About App

La siguiente aplicación muestra el juego del ahorcado en una versión web.  
Ha sido programado en **PHP 8.0** usando el framework **Laravel 8**.  
Dada la simplicidad de la aplicación, no ha sido necesario integrar una base de datos.

## ⚙️ Instalación

Ejecuta los siguientes comandos:

```bash
composer update
cp .env.example .env
php artisan key:generate
php artisan serve
```

## Funcionamiento

El proceso del juego consta de 3 pasos:
- En el primer paso, debes escoger el nº de jugadores que participarán asignandoles un avatar y un nombre
- En el segundo paso, cada jugador deberá descubrir su palabra oculta teniendo un máximo de 5 intentos. Cuando acabe su turno (al acertar la palabra o al fallar 5 veces) se saltará el turno al siguiente jugador. Al completar todos los turnos, se irá al paso 3
- En el tercer paso, podrás ver los resultados del juego (ganadores y perdedores) y podrás reiniciar el juego o solicitar una revancha

La lista de opciones disponibles para el juego la puedes encontrar en el siguiente enlace:
https://penjat.dinowebb.com/personajes.json

## Juegos de pruebas

Para asegurar el buen funcionamiento del juego, se han realizado las pruebas que aparecen en el documento de más abajo.
https://penjat.dinowebb.com/pruebas.pdf

## License
MIT License

Copyright (c) 2026 Luis Garcés

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.