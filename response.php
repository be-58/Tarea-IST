<?php
// Capturamos los parámetros que PayPhone adjunta nativamente en la URL tras el pago
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$clientTransactionId = isset($_GET['clientTransactionId']) ? $_GET['clientTransactionId'] : '';

// Datos de configuración (mismos que usas en index.php)
$token = 'lUUHQlX8mNOd3oqyn39uhqiCJCfi6LVTSzItuENb-MgWddzplfmHcXRcPNWAFF1yGFJ-phgEuDCB8cisWelD8YmsRiA5u2QjbTFFeCmbrvpgLzIg3-qdRjsRBUiYH4BWwxpd9WmTDHgkN3LuDEEo-pEizbUpkaGRdATRqQ38MF5lcPmeI2XVPB7izuUAE2eE_CY6lOBa1HLSioAO9iNiXnYvaojjy0KXLz30GBx1cox9Hr232p0nJY73Uo2cRr70tvhMzZKslBRiDsjoWcPqa3cJn2dstWmkjqXcVPWTJfsSlbAKeopnXKulmN1LuhsQwlbYbfmlJhwMHvEjkNmoUBIauvM';

$statusCode = null;
$transactionStatus = null;
$mensajeError = null;
$detalle = null;

if ($id && $clientTransactionId) {
    $headers = [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ];

    $data = [
        'id' => $id,
        'clientTxId' => $clientTransactionId
    ];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://pay.payphonetodoesposible.com/api/button/V2/Confirm');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        $mensajeError = curl_error($curl);
    }
    curl_close($curl);

    if ($response) {
        $detalle = json_decode($response, true);
        if (isset($detalle['statusCode'])) {
            $statusCode = $detalle['statusCode'];          // 1 = pendiente, 2 = cancelado, 3 = aprobado
            $transactionStatus = $detalle['transactionStatus'] ?? null; // "Approved", etc.
        } else {
            // PayPhone devolvió un error (ej. errorCode/message)
            $mensajeError = $detalle['message'] ?? 'Error desconocido al confirmar la transacción.';
        }
    }
}

$aprobado = ($statusCode === 3 || $transactionStatus === 'Approved');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Pago</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-md max-w-md w-full text-center">

        <?php if ($aprobado): ?>
            <!-- CASO EXCELENTE: PAGO APROBADO -->
            <div class="text-green-500 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">¡Pago Aprobado!</h1>
            <p class="text-gray-600 text-sm mb-6">La transacción ha sido procesada de manera exitosa en el entorno Sandbox.</p>

            <div class="bg-gray-50 p-4 rounded-lg text-left text-xs font-mono text-gray-700 space-y-2">
                <p><strong>ID Transacción:</strong> <?php echo htmlspecialchars($id); ?></p>
                <p><strong>ID Referencia:</strong> <?php echo htmlspecialchars($clientTransactionId); ?></p>
                <p><strong>Estado:</strong> <?php echo htmlspecialchars($transactionStatus ?? ''); ?> (statusCode: <?php echo htmlspecialchars($statusCode ?? ''); ?>)</p>
                <?php if (isset($detalle['authorizationCode'])): ?>
                    <p><strong>Código autorización:</strong> <?php echo htmlspecialchars($detalle['authorizationCode']); ?></p>
                <?php endif; ?>
                <?php if (isset($detalle['amount'])): ?>
                    <p><strong>Monto:</strong> $<?php echo htmlspecialchars(number_format($detalle['amount'] / 100, 2)); ?></p>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <!-- CASO TRÁMITE FALLIDO O CANCELADO -->
            <div class="text-red-500 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Pago No Aprobado</h1>
            <p class="text-gray-600 text-sm mb-4">La transacción fue cancelada o rechazada por la pasarela.</p>
            <p class="text-xs text-gray-400 mb-2">
                Estado: <?php echo htmlspecialchars($transactionStatus ?? 'N/A'); ?>
                (statusCode: <?php echo htmlspecialchars($statusCode ?? 'N/A'); ?>)
            </p>
            <?php if ($mensajeError): ?>
                <p class="text-xs text-red-400 mb-4"><?php echo htmlspecialchars($mensajeError); ?></p>
            <?php endif; ?>

            <a href="index.php" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                Intentar de nuevo
            </a>
        <?php endif; ?>

    </div>

</body>
</html>