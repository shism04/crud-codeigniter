<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/home.css') ?>">
</head>

<body>
    <header>
        <div class="logo">
            <a href="/">
                <span class="diff">NBA</span><span style="color: white;">CODEIGNITER</span>
            </a>
        </div>

        <div class="search-box">
            <form action="#" method="post">
                <div class="search">
                    <input type="text" placeholder="¿Qué estás buscando?..." name="busqueda" id="search-input">
                    <button type="submit" name="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="account">
            <img src="<?= base_url('images/icons/profile-user.png') ?>" alt="icon user" class="icon user" onclick="toggleOffCanvas()" />
            <img src="<?= base_url('images/icons/menu.png') ?>" alt="icon menu" class="icon menu" onclick="toggleOffCanvas()" />
        </div>

        <div class="off-canvas" id="offCanvas">
            <div class="off-canvas-content">
                <div class="top">
                    <div class="user">
                        <img src="<?= base_url('images/icons/profile-user (1).png') ?>" alt="User Icon" class="icon user" />
                        <span class="user-name">
                            Ismael
                        </span>
                    </div>
                    <img src="<?= base_url('images/icons/close (1).png') ?>" class="icon close" onclick="toggleOffCanvas()">
                </div>
                <div class="off-canvas-links">
                    <a href="../closeSess.php" class="log-out">
                        <img src="<?= base_url('images/icons/logout.png') ?>" alt="" class="icon log-out">
                        <span>Log out</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="hero">
        <div class="overlay"></div>
    </div>
    <div class="player-cards">
        <div class="sort-bar">
            <span class="sort-option">Nombre</span>
            <span class="sort-option">Años</span>
            <span class="sort-option">Champions</span>
            <span class="sort-option">All-NBA</span>
            <span class="sort-option">MVP</span>
            <span class="sort-option">Edad</span>
            <span class="sort-option">Altura</span>
        </div>
        <?php foreach ($jugadores as $jugador): ?>
            <div class="player-card">
                <!-- Número y Línea de Tiempo -->
                <div class="player-info">
                    <div class="left">
                        <span class="player-number"><?= $jugador['id'] ?></span>
                        <h2 class="player-name"><?= $jugador['nombre'] ?> <span class="team"><?= $jugador['equipo'] ?></span></h2>
                    </div>
                    <div class="actions">
                        <button id="editarbtn">EDITAR</button>
                        <a href="#">ELIMINAR</a>
                    </div>
                    <dialog>
                        <form method="post" action="<?= base_url('/editarJugador') ?>" enctype="multipart/form-data">
                            <h2>Editar Jugador</h2>
                            <input type="hidden" name="id" value="<?= $jugador['id'] ?>">

                            <div class="input-group">
                                <label for="nombre<?= $jugador['id'] ?>">Nombre:</label>
                                <input type="text" id="nombre<?= $jugador['id'] ?>" name="nombre" value="<?= $jugador['nombre'] ?>">
                            </div>

                            <div class="input-group">
                                <label for="equipo<?= $jugador['id'] ?>">Equipo:</label>
                                <input type="text" id="equipo<?= $jugador['id'] ?>" name="equipo" value="<?= $jugador['equipo'] ?>">
                            </div>

                            <!-- Resto de los campos para editar -->
                            <div class="input-group">
                                <label for="posicion<?= $jugador['id'] ?>">Posición:</label>
                                <input type="text" id="posicion<?= $jugador['id'] ?>" name="posicion" value="<?= $jugador['posicion'] ?>">
                            </div>

                            <div class="input-group">
                                <label for="altura<?= $jugador['id'] ?>">Altura:</label>
                                <input type="text" id="altura<?= $jugador['id'] ?>" name="altura" value="<?= $jugador['altura'] ?>">
                            </div>

                            <div class="input-group">
                                <label for="peso<?= $jugador['id'] ?>">Peso:</label>
                                <input type="text" id="peso<?= $jugador['id'] ?>" name="peso" value="<?= $jugador['peso'] ?>">
                            </div>

                            <div class="input-group">
                                <label for="edad<?= $jugador['id'] ?>">Edad:</label>
                                <input type="text" id="edad<?= $jugador['id'] ?>" name="edad" value="<?= $jugador['edad'] ?>">
                            </div>

                            <div class="input-group">
                                <label for="descripcion<?= $jugador['id'] ?>">Descripción:</label>
                                <textarea id="descripcion<?= $jugador['id'] ?>" name="descripcion"><?= $jugador['descripcion'] ?></textarea>
                            </div>

                            <!-- Imagen del jugador -->
                            <div class="image-container">
                                <img id="preview<?= $jugador['id'] ?>"
                                    src="<?= base_url('images/jugadores/' . ($jugador['foto'] ?? 'desconocido.png')) ?>"
                                    alt="Imagen del jugador">
                                <input type="file" name="foto" accept="image/*"
                                    onchange="previewImage(event, <?= $jugador['id'] ?>)">
                            </div>

                            <div class="btns">
                            <button type="submit" class="submit-button">Guardar cambios</button>
                            <button type="button" class="cancel-button" id="cancelar<?= $jugador['id'] ?>">Cancelar</button>
                            </div>
                        </form>
                    </dialog>
                </div>

                <div class="specific-info">
                    <!-- Imagen del jugador -->
                    <div class="image-container">
                        <div class="hidden">
                            <div class="overflow-hidden">
                                <?php if (isset($jugador['foto']) && !empty($jugador['foto'])) : ?>
                                    <img src="<?= base_url('images/jugadores/' . $jugador['foto']) ?>" alt="Jugador">
                                <?php else : ?>
                                    <img src="<?= base_url('images/jugadores/desconocido.png') ?>" alt="No hay foto del jugador">
                                <?php endif; ?>
                            </div>

                            <div class="bg">
                                <span class="position-tag"><?= $jugador['posicion'] ?></span>
                            </div>
                        </div>
                        <div class="player-phisic">
                            <div class="stats left">
                                <div class="stat"><strong>ALTURA:</strong> <span><?= $jugador['altura'] ?> m</span></div>
                                <div class="stat"><strong>PESO:</strong> <span><?= $jugador['peso'] ?> kg</span></div>
                            </div>
                            <div class="stats right">
                                <div class="stat"><strong>EDAD:</strong> <span><?= $jugador['edad'] ?></span></div>
                                <div class="stat"><strong>Partidos:</strong> <span><?= $jugador['partidos_jugados'] ?></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Jugador -->
                    <div class="player-details">
                        <p class="description">
                            <strong><?= $jugador['nombre'] ?></strong>,
                            <span class="light-text"><?= $jugador['descripcion'] ?></span>
                        </p>

                        <!-- Habilidades -->
                        <div class="trofeos">
                            <div class="trofeo champion">
                                <img src="<?= base_url('images/icons/rings.svg') ?>" alt="Icono Habilidad">
                                <p><span><?= $jugador['champion'] ?></span>x</p>
                                <span>Champion</span>
                            </div>
                            <div class="trofeo mvp">
                                <img src="<?= base_url('images/icons/mvps.svg') ?>" alt="Icono Habilidad">
                                <p><span><?= $jugador['mvp'] ?></span>x</p>
                                <span>MVP</span>
                            </div>
                            <div class="trofeo all-nba">
                                <img src="<?= base_url('images/icons/all_nba.svg') ?>" alt="Icono Habilidad">
                                <p><span><?= $jugador['all_nba'] ?></span>x</p>
                                <span>All-NBA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="container">
            <div></div>
            <div class="pagination">
                <form method="get" action="<?= base_url('/jugadores') ?>" id="pagination-form">
                    <!-- Select para el límite -->
                    <select name="limit" id="limit-select">
                        <option value="5" <?= $limit == 5 ? 'selected' : '' ?>>5</option>
                        <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
                    </select>

                    <?php
                    $totalPages = ceil($totalJugadores / $limit);

                    $prevPage = $pagina > 1 ? $pagina - 1 : 1;
                    echo '<button type="submit" name="pagina" value="' . $prevPage . '" class="page">Prev</button>';


                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo '<button type="submit" name="pagina" value="' . $i . '" class="page ' . ($i == $pagina ? 'active' : '') . '">' . $i . '</button>';
                    }

                    $nextPage = $pagina < $totalPages ? $pagina + 1 : $totalPages;
                    echo '<button type="submit" name="pagina" value="' . $nextPage . '" class="page">Next</button>';
                    ?>
                </form>
            </div>
        </div>
    </div>

    <?php $user_exist = session()->getFlashdata('success'); ?>
    <?php if (isset($user_exist)): ?>
        <script>
            alert('<?= session()->getFlashdata('success') ?>');
        </script>
    <?php endif; ?>
    <script src="<?= base_url('javascripts/offcanvas.js') ?>"></script>
    <script src="<?= base_url('javascripts/focus.js') ?>"></script>
    <script>
        const editarBtns = document.querySelectorAll('#editarbtn');

        editarBtns.forEach((btn) => {
            const dialog = btn.closest('.player-card').querySelector('dialog');
            const close = dialog.querySelector('.cancel-button');

            btn.addEventListener('click', () => {
                dialog.showModal();
                document.body.style.overflow = 'hidden'; 
            });

            close.addEventListener('click', () => {
                dialog.close();
                document.body.style.overflow = '';
            });
        });

        function previewImage(event, id) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById("preview" + id).src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>