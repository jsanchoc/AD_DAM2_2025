<?php
session_start();
// EscapeRoom F1 - single-file PHP game
// Autor: Generado con ayuda, adaptado por Jorge
// Instrucciones: coloca este archivo en un servidor PHP (o localhost). Usa /?sala=0..6 para navegar.

// --- Configuración del juego -------------------------------------------------
$rooms = [
    0 => ['title' => 'Sala 0 — Paddock (Inicio)', 'desc' => "Bienvenido al Grand Prix Escape Room. Empieza aquí. Lee las pistas con atención."],
    1 => ['title' => 'Sala 1 — Box / Garaje', 'desc' => "Llaves, herramientas y el volante. Observa las etiquetas en las cajas."],
    2 => ['title' => 'Sala 2 — Pit-lane', 'desc' => "Pit boards y cronos. A veces un milisegundo dice más de lo que crees."],
    3 => ['title' => 'Sala 3 — Paddock / Hospitality', 'desc' => "Fotos, trofeos y posters. A veces la leyenda es la pista."],
    4 => ['title' => 'Sala 4 — Race Control', 'desc' => "Pantallas de tiempos y banderas. Control de la carrera."],
    5 => ['title' => 'Sala 5 — Tribuna / Fan Zone', 'desc' => "Los fans siempre dejan mensajes y números curiosos en sus pancartas."],
    6 => ['title' => 'Sala 6 — Podio (FIN)', 'desc' => "¡Enhorabuena! Has llegado al final. Trofeo y celebración."],
];

// Candados definidos con claves (3 dígitos) y sala que desbloquean
$locks = [
    'C1' => ['code' => '707', 'unlock_room' => 4, 'clue_rooms' => [0,1,2], 'label' => 'Candado C1 — Dorsales y tiempos'],
    'C2' => ['code' => '430', 'unlock_room' => 5, 'clue_rooms' => [0,2,3], 'label' => 'Candado C2 — Podio y vueltas'],
    'C3' => ['code' => '951', 'unlock_room' => 2, 'clue_rooms' => [1,3,4], 'label' => 'Candado C3 — Neumáticos'],
    'C4' => ['code' => '384', 'unlock_room' => 5, 'clue_rooms' => [0,1,2,4], 'label' => 'Candado C4 — Vuelta rápida'],
    'C5' => ['code' => '317', 'unlock_room' => 6, 'clue_rooms' => [2,4,5], 'label' => 'Candado C5 — Clasificación final (3 intentos)'],
];

// Iniciar estado de sesión si no existe
if (!isset($_SESSION['unlocked'])) {
    $_SESSION['unlocked'] = [];
}
if (!isset($_SESSION['visited'])) {
    $_SESSION['visited'] = [0 => true];
}
if (!isset($_SESSION['pos'])) {
    $_SESSION['pos'] = 0; // sala actual
}
if (!isset($_SESSION['c5_attempts'])) {
    $_SESSION['c5_attempts'] = 0;
}

// Manejar acciones: mover de sala, intentar candado, reset
$sala = isset($_GET['sala']) ? intval($_GET['sala']) : $_SESSION['pos'];
$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['go_sala'])) {
        $target = intval($_POST['go_sala']);
        // permitir solo salas accesibles: sala 0 siempre; salas desbloqueadas o la sala destino si es la inicial
        $accessible = can_access_room($target);
        if ($accessible) {
            $_SESSION['pos'] = $target;
            $_SESSION['visited'][$target] = true;
            header('Location: ?sala=' . $target);
            exit;
        } else {
            $error = 'Esa sala aún no está desbloqueada.';
        }
    }

    if (isset($_POST['try_lock'])) {
        $lockId = $_POST['lock_id'];
        $entry = trim($_POST['code']);
        if (!isset($locks[$lockId])) {
            $error = 'Candado desconocido.';
        } else {
            // Validar formato: 3 dígitos
            if (!preg_match('/^\d{3}$/', $entry)) {
                $error = 'Introduce 3 dígitos para la clave.';
            } else {
                // Verifiquemos
                if ($entry === $locks[$lockId]['code']) {
                    // exitoso
                    $_SESSION['unlocked'][$lockId] = true;
                    $dest = $locks[$lockId]['unlock_room'];
                    $_SESSION['pos'] = $dest;
                    $_SESSION['visited'][$dest] = true;
                    // si acertaste C5, resetea intentos
                    if ($lockId === 'C5') $_SESSION['c5_attempts'] = 0;
                    $mensaje = "Has abierto {$lockId}! Te teletransportas a la sala {$dest}.";
                    header('Location: ?sala=' . $dest . '&msg=' . urlencode($mensaje));
                    exit;
                } else {
                    // fallido
                    if ($lockId === 'C5') {
                        $_SESSION['c5_attempts'] += 1;
                        $left = 3 - $_SESSION['c5_attempts'];
                        if ($_SESSION['c5_attempts'] >= 3) {
                            // respawn
                            session_unset();
                            session_destroy();
                            session_start();
                            $mensaje = 'Has fallado 3 veces en C5. Te han teletransportado a la Sala 0 y debes empezar de nuevo.';
                            header('Location: ?sala=0&msg=' . urlencode($mensaje));
                            exit;
                        } else {
                            $error = "Clave incorrecta. Intentos restantes para C5: {$left}.";
                        }
                    } else {
                        $error = 'Clave incorrecta.';
                    }
                }
            }
        }
    }

    if (isset($_POST['reset'])) {
        session_unset();
        session_destroy();
        session_start();
        header('Location: ?sala=0&msg=' . urlencode('Juego reiniciado.'));
        exit;
    }
}

if (isset($_GET['msg'])) $mensaje = htmlspecialchars($_GET['msg']);

// Funciones auxiliares
function can_access_room($roomId) {
    global $locks;
    // sala 0 siempre
    if ($roomId === 0) return true;
    // si ya la visitó, es accesible
    if (isset($_SESSION['visited'][$roomId]) && $_SESSION['visited'][$roomId]) return true;
    // si alguna candado abierto desbloquea esta sala
    foreach ($locks as $id => $cfg) {
        if (isset($_SESSION['unlocked'][$id]) && $_SESSION['unlocked'][$id] && $cfg['unlock_room'] === $roomId) return true;
    }
    return false;
}

function show_clues_for_lock_in_room($lockId, $roomId) {
    global $locks;
    if (!isset($locks[$lockId])) return '';
    return in_array($roomId, $locks[$lockId]['clue_rooms']);
}

function safe($s){ return htmlspecialchars($s); }

// --- Presentación HTML -------------------------------------------------------
?><!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Escape Room F1 — Sala <?php echo $sala; ?></title>
<style>
    :root{font-family:Inter, system-ui, sans-serif;color:#111}
    body{margin:0;background:#0b1220;color:#eef;padding:20px}
    .container{max-width:980px;margin:0 auto;background:linear-gradient(180deg,#071226 0%, #0d1b2a 100%);padding:18px;border-radius:10px;box-shadow:0 8px 30px rgba(0,0,0,0.6)}
    header{display:flex;align-items:center;justify-content:space-between}
    h1{margin:0;font-size:20px}
    nav a{color:#79c7ff;margin:0 8px;text-decoration:none}
    .rooms{display:flex;gap:8px;flex-wrap:wrap;margin:12px 0}
    .room-card{background:rgba(255,255,255,0.03);padding:12px;border-radius:8px;flex:1 0 150px}
    .lock{background:#071827;padding:10px;border-radius:8px;margin-top:8px}
    .clue{background:rgba(255,255,255,0.02);padding:8px;border-radius:6px;margin:6px 0;font-size:14px}
    .ok{color:#b6ffb0}
    .err{color:#ffb6b6}
    footer{margin-top:16px;font-size:13px;color:#9fb}
    .big{font-size:18px;margin:10px 0}
    .btn{background:#1b6ca8;padding:8px 12px;border-radius:6px;border:none;color:#fff;cursor:pointer}
    input[type="text"]{padding:8px;border-radius:6px;border:1px solid #234}
</style>
</head>
<body>
<div class="container">
<header>
    <h1>Escape Room F1 — <?php echo safe($rooms[$sala]['title']); ?></h1>
    <div>
        <form method="post" style="display:inline">
            <button class="btn" name="reset" onclick="return confirm('Reiniciar la partida?')">Reiniciar</button>
        </form>
    </div>
</header>

<?php if ($mensaje): ?><p class="big ok"><?php echo safe($mensaje); ?></p><?php endif; ?>
<?php if ($error): ?><p class="err"><?php echo safe($error); ?></p><?php endif; ?>

<main>
    <p><?php echo safe($rooms[$sala]['desc']); ?></p>

    <div class="rooms">
        <?php foreach ($rooms as $id => $r): ?>
            <div class="room-card">
                <strong><?php echo "Sala {$id}: ".safe($r['title']); ?></strong>
                <div style="font-size:13px;margin-top:6px;color:#9fb"><?php echo safe(substr($r['desc'],0,120)); ?>...</div>
                <form method="post" style="margin-top:8px">
                    <input type="hidden" name="go_sala" value="<?php echo $id; ?>">
                    <button class="btn" <?php echo can_access_room($id) ? '' : 'disabled'; ?>>Entrar</button>
                </form>
                <?php if (!can_access_room($id)): ?><div style="margin-top:8px;color:#cbb">(Bloqueada)</div><?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <section style="margin-top:16px">
        <h3>Pistas visibles en esta sala</h3>
        <?php
            // Mostrar pistas por sala: cada lock tiene pistas en ciertas salas
            $any = false;
            foreach ($locks as $lid => $cfg) {
                if (show_clues_for_lock_in_room($lid, $sala) && !isset($_SESSION['unlocked'][$lid])) {
                    $any = true;
                    echo "<div class='clue'><strong>Pista para {$cfg['label']} ({$lid})</strong><br>";
                    // Pistas concretas según lock y sala.
                    echo generate_clue_text($lid, $sala);
                    echo "</div>";
                }
            }
            if (!$any) echo "<div class='clue'>No hay pistas nuevas visibles aquí.</div>";
        ?>
    </section>

    <section style="margin-top:12px">
        <h3>Candados</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px">
        <?php foreach ($locks as $lid => $cfg): ?>
            <div class="lock">
                <strong><?php echo safe($lid . ' — ' . $cfg['label']); ?></strong>
                <div style="font-size:13px;margin-top:6px">Pistas en: <?php echo implode(', ', $cfg['clue_rooms']); ?></div>
                <div style="margin-top:8px">
                    <?php if (isset($_SESSION['unlocked'][$lid])): ?>
                        <div class="ok">Abierto ✅</div>
                    <?php else: ?>
                        <form method="post">
                            <input type="hidden" name="lock_id" value="<?php echo safe($lid); ?>">
                            <input type="text" name="code" maxlength="3" placeholder="Introduce 3 dígitos">
                            <button class="btn" name="try_lock">Intentar</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </section>

    <section style="margin-top:12px">
        <h3>Estado de la partida</h3>
        <div>Salas visitadas: <?php echo implode(', ', array_keys($_SESSION['visited'])); ?></div>
        <div style="margin-top:6px">Candados abiertos: <?php echo implode(', ', array_keys($_SESSION['unlocked'])); ?></div>
        <div style="margin-top:6px">Intentos en C5: <?php echo isset($_SESSION['c5_attempts']) ? intval($_SESSION['c5_attempts']) : 0; ?> / 3</div>
    </section>

</main>

<footer>
    <div>Consejo: las pistas son discretas. Observa años, dígitos sueltos y textos de pequeñas imágenes.</div>
</footer>

</div>

<?php
// Generador de texto de pistas (evita revelar la clave completa) 
function generate_clue_text($lockId, $roomId) {
    // Aquí devolvemos pistas en texto natural (no revelar la clave entera). Puedes ajustar o cambiar para hacer más críptico.
    $texts = [];
    switch ($lockId) {
        case 'C1':
            if ($roomId === 0) $texts[] = "Pequeña placa: 'Schumacher — Ferrari 7'. (Pista: dorsal famoso).";
            if ($roomId === 1) $texts[] = "Caja de herramientas etiquetada 'Pit stop 2004'. (Pista: mira el dígito central del año).";
            if ($roomId === 2) $texts[] = "Cronómetro del simulador con lectura 1:34.567. (Pista: fíjate en el último dígito de los milisegundos).";
            break;
        case 'C2':
            if ($roomId === 0) $texts[] = "Cartel pequeño: 'Ganador: Hamilton (44)'.";
            if ($roomId === 2) $texts[] = "Pit-board: 'Safety Car - Vuelta 13'.";
            if ($roomId === 3) $texts[] = "Leyenda bajo una foto: '1964'. Suma sus cifras para obtener una pista.";
            break;
        case 'C3':
            if ($roomId === 1) $texts[] = "Tres neumáticos con etiquetas: Soft (S), Medium (M), Hard (H).";
            if ($roomId === 3) $texts[] = "Gráfico de estrategia: 'S - M - H'.";
            if ($roomId === 4) $texts[] = "Pegatina de presión: '21.3 psi'. (Pista: observa la parte entera).";
            break;
        case 'C4':
            if ($roomId === 0) $texts[] = "Mapa con sectores numerados, la chicane marcada como '3'.";
            if ($roomId === 1) $texts[] = "Pizarra: 'Vuelta rápida 1:18.345'. (Toma nota del segundo de la vuelta).";
            if ($roomId === 2) $texts[] = "Pequeña bandera de sector repetida varias veces (cuenta cuántas).";
            if ($roomId === 4) $texts[] = "Panel con sectores y repeticiones. Fíjate en los contadores.";
            break;
        case 'C5':
            if ($roomId === 2) $texts[] = "Resumen: 'Piloto A - 312 puntos'. (Centena relevante).";
            if ($roomId === 4) $texts[] = "Registro de campeones: 2022, 2023, 2024. Observa los dorsales asociados en la foto de 2024.";
            if ($roomId === 5) $texts[] = "Pancarta de fan: 'Vamos #7!'.";
            $texts[] = "Atención: tienes 3 intentos para C5. En el tercer fallo volverás al inicio.";
            break;
    }
    return implode('<br>', $texts);
}

?>
</body>
</html>