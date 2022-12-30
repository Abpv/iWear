<?php
    require 'includes/funciones.php';
    incluirTemplate('header');
?>
    <main class="contenedor seccion contenido-centrado">
        <h1>Casa en Venta frente al bosque</h1>
        <picture>
            <source srcset="build/img/destacada.webp" type="image/webp">
            <source srcset="build/img/destacada.jpg" type="image/jpeg">
            <img loading="lazy" src="" alt="Imagen propiedad">
        </picture>
        <div class="resumen-propiedad">
            <p class="precio">$3.000.000</p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p>3</p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p>3</p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                    <p>4</p>
                </li>
            </ul>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque et nisi omnis exercitationem natus rerum, in nostrum amet vero pariatur eius, vel commodi suscipit eaque perferendis odit recusandae? Ad, et magnam. Nisi voluptatum ducimus earum ex explicabo, reiciendis ullam saepe?</p>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Debitis voluptatem optio dignissimos blanditiis, vero ea quae repellat tempora ullam aspernatur iusto praesentium fuga sint porro cumque saepe sequi libero ut!</p>
        </div>
    </main>

<?php
    incluirTemplate('footer');
?>