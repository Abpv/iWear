<?php
    require 'includes/app.php';
    incluirTemplate('header', $inicio = true);
?>
    
    <main class="contenedor seccion">
        <h1>Nuestros Productos</h1>
        <div class="contenedor-anuncios">
            <div class="anuncio">
                <picture>
                    <source srcset="build/img/anuncio1.webp" type="image/webp">
                    <source srcset="build/img/anuncio1.jpg" type="image/jpeg">
                    <img loading="lazy" src="" alt="Imagen anuncio">
                </picture>
                <div class="contenido-anuncio">
                    <h3>iWear v.1</h3>
                    <p>Tus compañeras del día a día</p>
                    <p class="precio">75€</p>
                    <a href="anuncio.html" class="boton-rosa-block">
                        Ver Producto
                    </a>
                </div><!--.contenido-anuncio-->
            </div><!--.anuncio-->
            <div class="anuncio">
                <picture>
                    <source srcset="build/img/anuncio2.webp" type="image/webp">
                    <source srcset="build/img/anuncio2.jpg" type="image/jpeg">
                    <img loading="lazy" src="" alt="Imagen anuncio">
                </picture>
                <div class="contenido-anuncio">
                    <h3>iWear v.1</h3>
                    <p>Dale un toque de color</p>
                    <p class="precio">85€</p>
                    <a href="anuncio.html" class="boton-rosa-block">
                        Ver Producto
                    </a>
                </div><!--.contenido-anuncio-->
            </div><!--.anuncio-->
            <div class="anuncio">
                <picture>
                    <source srcset="build/img/anuncio3.webp" type="image/webp">
                    <source srcset="build/img/anuncio3.jpg" type="image/jpeg">
                    <img loading="lazy" src="" alt="Imagen anuncio">
                </picture>
                <div class="contenido-anuncio">
                    <h3>iWear v.3</h3>
                    <p>La opción más elegante</p>
                    <p class="precio">125€</p>
                    <a href="anuncio.html" class="boton-rosa-block">
                        Ver Producto
                    </a>
                </div><!--.contenido-anuncio-->
            </div><!--.anuncio-->
        </div><!--.contenedor-anuncios-->
        <?php
            // $limite = 3;
            // include 'includes/templates/anuncios.php';
        ?>


        <div class="alinear-derecha">
            <a href="anuncios.html" class="boton-azul">Ver Todas</a>
        </div>
    </main><!--sobrenosotros-->

    <section class="imagen-contacto">
        <h2>Encuentra tus gafas perfectas</h2>
        <p>Rellena el formulario de contacto y pide cita, nosotros te asesoramos</p>
        <a href="contacto.html" class="boton-azul">Contáctanos</a>
    </section><!--contacto-->

    <div class="contenedor seccion seccion-inferior">
        <section class="blog">
            <h3>Nuestro Blog</h3>
            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog1.webp" type="image/webp">
                        <source srcset="build/img/blog1.jpg" type="image/jpeg">
                        
                        <img loading="lazy" src="" alt="Imagen ">
                    </picture>
                </div>
                <div class="texto-entrada">
                    <a href="entrada.html">
                        <h4>Las gafas de sol no son solo para el verano</h4>
                        <p class="informacion-meta">Escrito el: <span>20/10/2021</span> por: <span>Admin</span></p>
                        <p>Todas las novedades para este otoño, con la opinión de nuestros expertos sobre las últimas tendencias</p>
                    </a>
                </div>
            </article>
            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog2.webp" type="image/webp">
                        <source srcset="build/img/blog2.jpg" type="image/jpeg">
                        
                        <img loading="lazy" src="" alt="Imagen ">
                    </picture>
                </div>
                <div class="texto-entrada">
                    <a href="entrada.html">
                        <h4>No todas las caras son iguales</h4>
                        <p class="informacion-meta">Escrito el: <span>20/10/2021</span> por: <span>Admin</span></p>
                        <p>Cada persona es un mundo y para cada una de ellas existen un par de gafas que le pasaran como anillo al dedo</p>
                    </a>
                </div>
            </article>
        </section>

        <section class="testimoniales">
            <h3>Testimonios</h3>
            <div class="testimonial">
                <blockquote>
                    Encantada con la visita a la tienda del centro, me atendieron de forma personalizada y muy amablemente
                </blockquote>
                <p>- María Sánchez</p>
            </div>
        </section>
    </div><!--blog-->

<?php
    include 'includes/templates/footer.php';
?>