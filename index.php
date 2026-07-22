<?php
$productos = [
  ['id'=>1,'nombre'=>'Audífonos Pro X',  'emoji'=>'🎧','desc'=>'Cancelación activa de ruido, Bluetooth 5.3', 'precio_centavos'=>1299,'subtotal'=>1160,'iva'=>139],
  ['id'=>2,'nombre'=>'Smartwatch Lite',  'emoji'=>'⌚','desc'=>'Monitor de salud, GPS, 7 días de batería',   'precio_centavos'=>850, 'subtotal'=>759, 'iva'=>91],
  ['id'=>3,'nombre'=>'Teclado Mecánico', 'emoji'=>'⌨️','desc'=>'Switches táctiles, retroiluminación RGB',    'precio_centavos'=>1500,'subtotal'=>1339,'iva'=>161],
  ['id'=>4,'nombre'=>'Webcam 4K',        'emoji'=>'📷','desc'=>'Video ultra nítido, micrófono integrado',    'precio_centavos'=>1000,'subtotal'=>893, 'iva'=>107],
  ['id'=>5,'nombre'=>'Cable USB-C 3m',   'emoji'=>'🔌','desc'=>'Carga rápida 65W, transferencia 10Gbps',     'precio_centavos'=>250, 'subtotal'=>250, 'iva'=>0],
  ['id'=>6,'nombre'=>'Mousepad XXL',     'emoji'=>'🖱️','desc'=>'Base antideslizante, superficie de tela',    'precio_centavos'=>400, 'subtotal'=>400, 'iva'=>0],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>2   |
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tienda Uleam Prueba Alisson — PayPhone</title>

  <script src="https://cdn.payphonetodoesposible.com/box/v2.0/payphone-payment-box.js"></script>
  <link href="https://cdn.payphonetodoesposible.com/box/v2.0/payphone-payment-box.css" rel="stylesheet">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap');
    :root {
      --bg:#0f1117;--surface:#181c27;--surface2:#1e2333;
      --border:#2a2f42;--accent:#00d4aa;--accent2:#0099ff;
      --danger:#ff4d6d;--warn:#ffb703;--text:#e8eaf6;--muted:#7c85a2;
      --radius:12px;--font-display:'Space Grotesk',sans-serif;--font-body:'Inter',sans-serif;
    }
    *{box-sizing:border-box;margin:0;padding:0;}
    body{background:var(--bg);color:var(--text);font-family:var(--font-body);min-height:100vh;}

    nav{background:var(--surface);border-bottom:1px solid var(--border);padding:0 32px;height:60px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;}
    .nav-brand{font-family:var(--font-display);font-size:20px;font-weight:700;color:var(--accent);display:flex;align-items:center;gap:8px;}
    .nav-badge{background:var(--accent);color:var(--bg);font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px;letter-spacing:.5px;}

    .container{max-width:1100px;margin:0 auto;padding:40px 24px;}
    h1{font-family:var(--font-display);font-size:28px;font-weight:700;margin-bottom:6px;}
    .subtitle{color:var(--muted);font-size:14px;margin-bottom:32px;}

    .tabs{display:flex;gap:4px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:4px;margin-bottom:28px;width:fit-content;}
    .tab{padding:8px 20px;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;border:none;background:none;color:var(--muted);transition:all .2s;}
    .tab.active{background:var(--accent);color:var(--bg);}
    .tab:hover:not(.active){color:var(--text);background:var(--surface2);}
    .panel{display:none;}.panel.active{display:block;}

    .product-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px;}
    .product-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:border-color .2s,transform .2s;}
    .product-card:hover{border-color:var(--accent);transform:translateY(-2px);}
    .product-img{height:140px;display:flex;align-items:center;justify-content:center;font-size:56px;background:var(--surface2);}
    .product-info{padding:16px;}
    .product-name{font-weight:600;font-size:15px;margin-bottom:4px;}
    .product-desc{color:var(--muted);font-size:12px;margin-bottom:14px;line-height:1.5;}
    .product-footer{display:flex;justify-content:space-between;align-items:center;}
    .product-price{font-family:var(--font-display);font-size:20px;font-weight:700;color:var(--accent);}
    .product-price small{font-size:11px;color:var(--muted);font-family:var(--font-body);font-weight:400;}
    .btn-add{background:var(--accent);color:var(--bg);border:none;padding:8px 14px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;transition:opacity .2s;}
    .btn-add:hover{opacity:.85;}

    .checkout-grid{display:grid;grid-template-columns:1fr 380px;gap:28px;}
    @media(max-width:800px){.checkout-grid{grid-template-columns:1fr;}}

    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:24px;}
    .card-title{font-family:var(--font-display);font-size:16px;font-weight:700;margin-bottom:18px;display:flex;align-items:center;gap:8px;}
    .card-title .icon{width:28px;height:28px;background:var(--surface2);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;}

    .form-row{margin-bottom:14px;}
    label{display:block;font-size:12px;font-weight:500;color:var(--muted);margin-bottom:5px;text-transform:uppercase;letter-spacing:.4px;}
    input{width:100%;background:var(--surface2);border:1px solid var(--border);border-radius:8px;padding:10px 12px;color:var(--text);font-size:14px;font-family:var(--font-body);transition:border-color .2s;outline:none;}
    input:focus{border-color:var(--accent);}
    input::placeholder{color:var(--muted);}
    .form-2col{display:grid;grid-template-columns:1fr 1fr;gap:12px;}

    .order-item{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border);font-size:14px;}
    .order-item:last-child{border-bottom:none;}
    .order-item-name{display:flex;align-items:center;gap:10px;}
    .order-item-emoji{font-size:22px;}
    .order-item-title{font-weight:500;font-size:13px;}
    .order-item-qty{color:var(--muted);font-size:11px;}
    .order-item-price{font-weight:600;color:var(--accent);}
    .order-totals{border-top:1px solid var(--border);padding-top:14px;}
    .total-row{display:flex;justify-content:space-between;font-size:13px;color:var(--muted);margin-bottom:6px;}
    .total-row.grand{color:var(--text);font-size:16px;font-weight:700;margin-top:8px;padding-top:10px;border-top:1px solid var(--border);}
    .total-row.grand span:last-child{color:var(--accent);}

    .payphone-wrapper{margin-top:20px;display:flex;flex-direction:column;gap:10px;}
    #btn-proceder{background:linear-gradient(135deg,#00d4aa,#0099ff);color:#fff;border:none;width:100%;padding:14px;border-radius:10px;font-size:15px;font-weight:700;font-family:var(--font-display);cursor:pointer;display:flex;align-items:center;justify-content:center;gap:10px;transition:opacity .2s,transform .15s;box-shadow:0 4px 20px rgba(0,212,170,.25);}
    #btn-proceder:hover{opacity:.9;transform:translateY(-1px);}
    #btn-proceder:disabled{opacity:.5;cursor:not-allowed;transform:none;background:var(--surface2);box-shadow:none;}
    .payphone-logo{background:rgba(255,255,255,.2);border-radius:6px;padding:3px 8px;font-size:11px;font-weight:800;letter-spacing:1px;}
    .sandbox-badge{text-align:center;font-size:11px;color:var(--warn);display:flex;align-items:center;justify-content:center;gap:5px;}
    #pp-button{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);padding:12px;}
    .hidden{display:none;}

    .alert{padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:16px;display:flex;align-items:flex-start;gap:10px;}
    .alert.info{background:rgba(0,153,255,.1);border:1px solid rgba(0,153,255,.3);color:#7dd3fc;}
    .alert.warn{background:rgba(255,183,3,.1);border:1px solid rgba(255,183,3,.3);color:var(--warn);}
    .empty-cart{text-align:center;padding:60px 20px;color:var(--muted);}
    .empty-cart .big{font-size:48px;margin-bottom:12px;}

    .test-card-item{display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:var(--surface2);border:1px solid var(--border);border-radius:8px;margin-bottom:8px;font-size:13px;}
    .card-num{font-family:monospace;font-size:14px;letter-spacing:1px;}
    .copy-btn{background:none;border:1px solid var(--border);color:var(--muted);padding:3px 10px;border-radius:5px;font-size:11px;cursor:pointer;transition:all .2s;}
    .copy-btn:hover{border-color:var(--accent);color:var(--accent);}
    .cart-count{background:var(--danger);color:#fff;font-size:10px;font-weight:700;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;margin-left:6px;}
  </style>
</head>
<body>

<nav>
  <div class="nav-brand">
    💳 Pay<span style="color:white">Demo</span>
    <span class="nav-badge">SANDBOX</span>
  </div>
  <div style="display:flex;align-items:center;gap:16px;font-size:13px;color:var(--muted)">
    <span>Tienda Uleam Prueba</span>
    <span style="cursor:pointer;color:var(--text)" onclick="switchTab('checkout')">
      🛒 Carrito <span class="cart-count" id="cart-count">0</span>
    </span>
  </div>
</nav>

<div class="container">
  <h1>Tienda Johan</h1>
  <p class="subtitle">Integración con PayPhone SDK v2.0 · Dayana Anchundia · Modo Sandbox · Build automático </p>

  <div class="tabs">
    <button class="tab active" onclick="switchTab('tienda')">🛍 Tienda</button>
    <button class="tab" onclick="switchTab('checkout')">💳 Pagar</button>
    <button class="tab" onclick="switchTab('response')">📨 Response API</button>
    <button class="tab" onclick="switchTab('historial')">📋 Historial</button>
  </div>

  <!-- TIENDA -->
  <div id="panel-tienda" class="panel active">
    <div class="alert info">ℹ️ &nbsp;Selecciona productos y ve a <strong>Pagar</strong> para ejecutar la transacción con PayPhone.</div>
    <div class="product-grid">
      <?php foreach($productos as $p): ?>
      <div class="product-card">
        <div class="product-img"><?= $p['emoji'] ?></div>
        <div class="product-info">
          <div class="product-name"><?= htmlspecialchars($p['nombre']) ?></div>
          <div class="product-desc"><?= htmlspecialchars($p['desc']) ?></div>
          <div class="product-footer">
            <div class="product-price">$<?= number_format($p['precio_centavos']/100,2) ?> <small>+ IVA</small></div>
            <button class="btn-add" onclick="agregarAlCarrito(<?= $p['id'] ?>,'<?= htmlspecialchars($p['nombre']) ?>','<?= $p['emoji'] ?>',<?= $p['precio_centavos'] ?>,<?= $p['subtotal'] ?>,<?= $p['iva'] ?>)">+ Agregar</button>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- CHECKOUT -->
  <div id="panel-checkout" class="panel">
    <div id="empty-cart" class="empty-cart">
      <div class="big">🛒</div>
      <p>El carrito está vacío.<br>Agrega productos desde la <strong>Tienda</strong>.</p>
    </div>
    <div id="checkout-content" class="checkout-grid" style="display:none">
      <div>
        <div class="card" style="margin-bottom:20px">
          <div class="card-title"><div class="icon">👤</div> Datos del cliente</div>
          <div class="form-2col">
            <div class="form-row"><label>Nombre</label><input id="f-name" type="text" value="Dayana"/></div>
            <div class="form-row"><label>Apellido</label><input id="f-lastname" type="text" value="Anchundia"/></div>
          </div>
          <div class="form-row"><label>Correo electrónico</label><input id="f-email" type="email" value="dayana@uleam.edu.ec"/></div>
          <div class="form-row"><label>Teléfono</label><input id="f-phone" type="tel" value="0987654321"/></div>
        </div>

        <div class="card">
          <div class="card-title"><div class="icon">🧾</div> Resumen del pedido</div>
          <div id="order-items"></div>
          <div id="order-totals" class="order-totals"></div>
          <div class="payphone-wrapper">
            <button id="btn-proceder" onclick="inicializarPagoPayPhone()" disabled>
              💳 <span>Pagar con</span>
              <span class="payphone-logo">PAYPHONE</span>
            </button>
            <div id="pp-button" class="hidden"></div>
            <div class="sandbox-badge">🔬 Modo sandbox — no se cobra dinero real</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- RESPONSE -->
  <div id="panel-response" class="panel">
    <div id="no-response" class="empty-cart">
      <div class="big">📭</div>
      <p>Aún no hay respuesta.<br>Ejecuta una transacción desde <strong>Pagar</strong>.</p>
    </div>
    <div id="response-panel" style="display:none"></div>
  </div>

  <!-- HISTORIAL -->
  <div id="panel-historial" class="panel">
    <div class="card">
      <div class="card-title"><div class="icon">📋</div> Historial de transacciones</div>
      <div id="log-content"><div class="log-empty">📭 Sin transacciones registradas aún.</div></div>
    </div>
  </div>
</div>

<script>
  const CONFIG = {
    token: 'lUUHQlX8mNOd3oqyn39uhqiCJCfi6LVTSzItuENb-MgWddzplfmHcXRcPNWAFF1yGFJ-phgEuDCB8cisWelD8YmsRiA5u2QjbTFFeCmbrvpgLzIg3-qdRjsRBUiYH4BWwxpd9WmTDHgkN3LuDEEo-pEizbUpkaGRdATRqQ38MF5lcPmeI2XVPB7izuUAE2eE_CY6lOBa1HLSioAO9iNiXnYvaojjy0KXLz30GBx1cox9Hr232p0nJY73Uo2cRr70tvhMzZKslBRiDsjoWcPqa3cJn2dstWmkjqXcVPWTJfsSlbAKeopnXKulmN1LuhsQwlbYbfmlJhwMHvEjkNmoUBIauvM',
    storeId: '4564c760-c9c5-4988-9880-c6f2b388f37f',
    responseUrl: 'http://localhost:8081/proyecto-payphone-php/response.php'
  };

  let carrito = [];

  function agregarAlCarrito(id, nombre, emoji, total, subtotal, iva) {
    document.getElementById('pp-button').classList.add('hidden');
    document.getElementById('btn-proceder').classList.remove('hidden');
    const existe = carrito.find(p => p.id === id);
    if (existe) {
      existe.cantidad++;
    } else {
      carrito.push({ id, nombre, emoji, total, subtotal, iva, cantidad: 1 });
    }
    renderizarCarrito();
  }

  function renderizarCarrito() {
    const isEmpty = carrito.length === 0;
    document.getElementById('empty-cart').style.display = isEmpty ? 'block' : 'none';
    document.getElementById('checkout-content').style.display = isEmpty ? 'none' : 'grid';
    document.getElementById('btn-proceder').disabled = isEmpty;
    document.getElementById('cart-count').textContent = carrito.reduce((s,p) => s + p.cantidad, 0);

    if (isEmpty) {
      document.getElementById('order-items').innerHTML = '';
      renderTotales(0, 0, 0);
      return;
    }

    let totalAcum = 0, sub0 = 0, sub15 = 0, ivaAcum = 0;
    document.getElementById('order-items').innerHTML = carrito.map(p => {
      const itemTotal = p.total * p.cantidad;
      totalAcum += itemTotal;
      if (p.iva === 0) {
        sub0 += itemTotal;
      } else {
        sub15 += p.subtotal * p.cantidad;
        ivaAcum += p.iva * p.cantidad;
      }
      return `
        <div class="order-item">
          <div class="order-item-name">
            <span class="order-item-emoji">${p.emoji}</span>
            <div>
              <div class="order-item-title">${p.nombre}</div>
              <div class="order-item-qty">x${p.cantidad} · $${(p.total/100).toFixed(2)} c/u</div>
            </div>
          </div>
          <span class="order-item-price">$${(itemTotal/100).toFixed(2)}</span>
        </div>`;
    }).join('');

    renderTotales(totalAcum, sub0, sub15, ivaAcum);

    const btn = document.getElementById('btn-proceder');
    btn.dataset.total = totalAcum;
    btn.dataset.sub0 = sub0;
    btn.dataset.sub15 = sub15;
    btn.dataset.iva = ivaAcum;
  }

  function renderTotales(total, sub0, sub15, iva) {
    const base = sub0 + sub15;
    document.getElementById('order-totals').innerHTML = total === 0 ? '' : `
      <div class="total-row"><span>Subtotal (sin IVA)</span><span>$${(base/100).toFixed(2)}</span></div>
      <div class="total-row"><span>IVA</span><span>$${(iva/100).toFixed(2)}</span></div>
      <div class="total-row grand"><span>Total a pagar</span><span>$${(total/100).toFixed(2)}</span></div>`;
  }

  function inicializarPagoPayPhone() {
    if (typeof PPaymentButtonBox === 'undefined') {
      alert('SDK de PayPhone aún cargando, espera un momento.');
      return;
    }

    const btn = document.getElementById('btn-proceder');
    const total = parseInt(btn.dataset.total, 10);
    const sub0  = parseInt(btn.dataset.sub0,  10);
    const sub15 = parseInt(btn.dataset.sub15, 10);
    const iva   = parseInt(btn.dataset.iva,   10);
    const transactionId = 'TXN-' + Date.now();

    const ppDiv = document.getElementById('pp-button');
    ppDiv.innerHTML = '';
    ppDiv.classList.remove('hidden');
    btn.classList.add('hidden');

    new PPaymentButtonBox({
      token: CONFIG.token,
      storeId: CONFIG.storeId,
      clientTransactionId: transactionId,
      amount: total,
      amountWithoutTax: sub0,
      amountWithTax: sub15,
      tax: iva,
      currency: 'USD',
      reference: `Pedido Uleam · ${carrito.length} producto(s)`,
      email: document.getElementById('f-email').value || '',
      responseUrl: CONFIG.responseUrl
    }).render('pp-button');
  }

  function switchTab(name) {
    document.querySelectorAll('.tab').forEach((t, i) => {
      t.classList.toggle('active', ['tienda', 'checkout'][i] === name);
    });
    document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
    document.getElementById('panel-' + name).classList.add('active');
  }
</script>