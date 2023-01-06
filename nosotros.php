<?php
    require 'includes/app.php';
    incluirTemplate('header', $inicio=false);
?>
    
    <main class="contenedor seccion">
        <h1>Sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                    <img loading="lazy" src="" alt="Imagen nosotros">
                </picture>
            </div>
            <div class="texto-nosotros">
                <blockquote>
                    25 años de experiencia
                </blockquote>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt, vel. Laborum, voluptatem dolore itaque molestiae vel natus asperiores laboriosam debitis quas eligendi commodi aut cupiditate sed! Deserunt, repudiandae. Quae quam nostrum ipsum minus ratione aperiam numquam impedit consequatur doloribus assumenda necessitatibus officiis doloremque, nihil porro corrupti labore rerum voluptates eum?
                </p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil sunt, inventore officiis est culpa totam consequatur ut unde explicabo laudantium quo nisi quidem. Cum dolorem quas voluptatibus voluptate, animi veniam.</p>

            </div>
        </div>
    </main>
    
    <section class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>
        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nemo tempore officiis voluptatibus veniam adipisci consectetur!</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="icono precio" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nemo tempore officiis voluptatibus veniam adipisci consectetur!</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="icono tiempo" loading="lazy">
                <h3>A Tiempo</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nemo tempore officiis voluptatibus veniam adipisci consectetur!</p>
            </div>
        </div>
    </section>

<?php
    incluirTemplate('footer');
?>