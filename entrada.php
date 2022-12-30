<?php
    require 'includes/funciones.php';
    incluirTemplate('header');
?>
    
    <main class="contenedor seccion contenido-centrado">
        <h1>Terraza en el techo de tu casa</h1>
        <picture>
            <source srcset="build/img/destacada2.webp" type="image/webp">
            <source srcset="build/img/destacada2.jpg" type="image/jpeg">
            <img loading="lazy" src="" alt="Imagen propiedad">
        </picture>
        <p class="informacion-meta">Escrito el: <span>20/10/2021</span> por: <span>Admin</span></p>

        <div class="resumen-propiedad">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque et nisi omnis exercitationem natus rerum, in nostrum amet vero pariatur eius, vel commodi suscipit eaque perferendis odit recusandae? Ad, et magnam. Nisi voluptatum ducimus earum ex explicabo, reiciendis ullam saepe?</p>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Debitis voluptatem optio dignissimos blanditiis, vero ea quae repellat tempora ullam aspernatur iusto praesentium fuga sint porro cumque saepe sequi libero ut!</p>
        </div>
    </main>

<?php
    incluirTemplate('footer');
?>