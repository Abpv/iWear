<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Título</label>
    <input type="text" name="titulo" id="titulo" placeholder="Título de la Propiedad" value="<?php echo s($propiedad->titulo); ?>">

    <label for="precio">Precio</label>
    <input type="number" name="precio" id="precio" min="1" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>">

    <label for="imagen">Imágen</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

    <label for="descripcion">Descripción</label>
    <!--textarea no tiene value, lo ponemos entre las etiquetas-->
    <textarea name="descripcion" id="descripcion"><?php echo s($propiedad->descripcion); ?></textarea>

</fieldset>

<fieldset>
    <legend>Información Propiedad</legend>

    <label for="habitaciones">Habitaciones</label>
    <input type="number" name="habitaciones" id="habitaciones" min="1" max="9" placeholder="Ej: 3" value="<?php echo s($propiedad->habitaciones); ?>">

    <label for="wc">Baños</label>
    <input type="number" name="wc" id="wc" min="1" max="9" placeholder="Ej: 3" value="<?php echo s($propiedad->wc); ?>">

    <label for="estacionamiento">estacionamiento</label>
    <input type="number" name="estacionamiento" id="estacionamiento" min="1" max="9" placeholder="Ej: 3" value="<?php echo s($propiedad->estacionamiento); ?>">
</fieldset>

<fieldset>
    <legend>Vendedor</legend>
</fieldset>
