<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PedidosYa — Pide lo que quieras</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #fff7f0; color: #1a1a1a; }

        /* NAV */
        nav {
            display: flex; justify-content: space-between; align-items: center;
            padding: 1.1rem 2.5rem;
            background: white;
            border-bottom: 2px solid #ff6b00;
            box-shadow: 0 1px 8px rgba(0,0,0,.06);
            position: sticky; top: 0; z-index: 100;
        }
        .nav-brand { font-size: 1.5rem; font-weight: 800; color: #ff6b00; letter-spacing: -0.5px; }
        .nav-brand span { color: #1a1a1a; }
        .nav-links { display: flex; gap: 1rem; }
        .nav-links a {
            padding: .5rem 1.2rem; border-radius: 8px;
            font-weight: 600; font-size: .9rem; text-decoration: none;
            transition: all .2s;
        }
        .btn-login { color: #ff6b00; border: 2px solid #ff6b00; }
        .btn-login:hover { background: #ff6b00; color: white; }
        .btn-register { background: #ff6b00; color: white; border: 2px solid #ff6b00; }
        .btn-register:hover { background: #e55a00; border-color: #e55a00; }
        .btn-dashboard { background: #1a1a1a; color: white; border: 2px solid #1a1a1a; }
        .btn-dashboard:hover { background: #333; }

        /* HERO */
        .hero {
            max-width: 1100px; margin: 0 auto;
            padding: 5rem 2rem 4rem;
            display: flex; align-items: center; gap: 4rem;
            flex-wrap: wrap;
        }
        .hero-text { flex: 1; min-width: 280px; }
        .hero-badge {
            display: inline-block;
            background: #fff0e0; color: #ff6b00;
            font-weight: 700; font-size: .8rem; letter-spacing: .05em;
            padding: .35rem .9rem; border-radius: 50px; margin-bottom: 1.2rem;
            border: 1px solid #ffd0a0;
        }
        .hero-text h1 {
            font-size: 3.2rem; font-weight: 800; line-height: 1.15;
            margin-bottom: 1.2rem; color: #1a1a1a;
        }
        .hero-text h1 span { color: #ff6b00; }
        .hero-text p { font-size: 1.1rem; color: #555; line-height: 1.7; margin-bottom: 2rem; }
        .hero-cta { display: flex; gap: 1rem; flex-wrap: wrap; }
        .cta-primary {
            text-decoration: none; background: #ff6b00; color: white;
            font-weight: 700; padding: .85rem 2rem;
            border-radius: 10px; font-size: 1rem;
            box-shadow: 0 4px 14px rgba(255,107,0,.35); transition: all .2s;
        }
        .cta-primary:hover { background: #e55a00; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(255,107,0,.45); }
        .cta-secondary {
            text-decoration: none; background: white; color: #1a1a1a;
            font-weight: 600; padding: .85rem 2rem;
            border-radius: 10px; font-size: 1rem;
            border: 2px solid #e0e0e0; transition: all .2s;
        }
        .cta-secondary:hover { border-color: #ff6b00; color: #ff6b00; }

        /* HERO VISUAL */
        .hero-visual {
            flex: 1; max-width: 400px; min-width: 280px;
            background: white; border-radius: 20px; padding: 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,.1); border: 1px solid #ffe0c0;
        }
        .mock-product {
            display: flex; align-items: center; gap: 1rem;
            padding: .9rem; border-radius: 12px; margin-bottom: .75rem;
            background: #fff7f0; border: 1px solid #ffe5cc; transition: all .2s;
        }
        .mock-product:hover { transform: translateX(4px); }
        .mock-product:last-child { margin-bottom: 0; }
        .mock-icon {
            width: 52px; height: 52px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; flex-shrink: 0;
        }
        .mock-product-info { flex: 1; }
        .mock-product-info strong { display: block; font-size: .95rem; color: #1a1a1a; }
        .mock-product-info span { font-size: .82rem; color: #888; }
        .mock-price { font-weight: 700; color: #ff6b00; font-size: .95rem; }
        .mock-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.2rem; padding-bottom: 1rem; border-bottom: 1px solid #f0e0d0;
        }
        .mock-header strong { font-size: 1rem; color: #1a1a1a; }
        .mock-tag {
            background: #ff6b00; color: white;
            font-size: .72rem; font-weight: 700; padding: .2rem .6rem; border-radius: 50px;
        }

        /* FEATURES */
        .features { background: white; padding: 5rem 2rem; }
        .features-inner { max-width: 1100px; margin: 0 auto; }
        .section-title { text-align: center; margin-bottom: 3.5rem; }
        .section-title h2 { font-size: 2.1rem; font-weight: 800; color: #1a1a1a; }
        .section-title p { color: #666; margin-top: .6rem; font-size: 1rem; }
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; }
        .feature-card {
            padding: 2rem; border-radius: 16px; border: 1px solid #f0e0d0;
            background: #fff7f0; transition: all .25s;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(255,107,0,.12); border-color: #ff6b00; }
        .feature-icon { font-size: 2.2rem; margin-bottom: 1rem; }
        .feature-card h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: .5rem; color: #1a1a1a; }
        .feature-card p { font-size: .9rem; color: #666; line-height: 1.6; }

        /* FOOTER */
        footer { padding: 2rem; text-align: center; color: #999; font-size: .85rem; background: white; border-top: 1px solid #f0e0d0; }
        footer strong { color: #ff6b00; }
    </style>
</head>
<body>

    <nav>
        <div class="nav-brand">Pedidos<span>Ya</span></div>
        @if (Route::has('login'))
            <div class="nav-links">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-dashboard">Mi Panel</a>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Iniciar Sesión</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-register">Registrarse</a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>

    <!-- HERO -->
    <section style="background: linear-gradient(135deg, #fff7f0 0%, #ffe8d0 100%);">
        <div class="hero">
            <div class="hero-text">
                <div class="hero-badge">🚀 Tu app de domicilios en Bucaramanga</div>
                <h1>Pide lo que quieras, <span>cuando quieras</span></h1>
                <p>Conectamos clientes, comercios y repartidores en una sola plataforma. Rápido, seguro y fácil de usar.</p>
                <div class="hero-cta">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="cta-primary">Ir a mi panel →</a>
                    @else
                        <a href="{{ route('register') }}" class="cta-primary">Empieza gratis →</a>
                        <a href="{{ route('login') }}" class="cta-secondary">Ya tengo cuenta</a>
                    @endauth
                </div>
            </div>
            <div class="hero-visual">
                <div class="mock-header">
                    <strong>🔥 Ofertas de hoy</strong>
                    <span class="mock-tag">Bucaramanga</span>
                </div>
                <div class="mock-product">
                    <div class="mock-icon" style="background:#fff0e0;">🍕</div>
                    <div class="mock-product-info">
                        <strong>Pizza Pepperoni</strong>
                        <span>Desde $20.000 · Juan Chaparro</span>
                    </div>
                    <span class="mock-price">⭐ 4.9</span>
                </div>
                <div class="mock-product">
                    <div class="mock-icon" style="background:#e8f5e9;">🍔</div>
                    <div class="mock-product-info">
                        <strong>Hamburguesa Angus</strong>
                        <span>Desde $30.000 · BurgerHouse</span>
                    </div>
                    <span class="mock-price">⭐ 4.8</span>
                </div>
                <div class="mock-product">
                    <div class="mock-icon" style="background:#e3f2fd;">🍦</div>
                    <div class="mock-product-info">
                        <strong>Helado Chocolate</strong>
                        <span>Desde $5.000 · Creamería</span>
                    </div>
                    <span class="mock-price">⭐ 4.7</span>
                </div>
                <div style="margin-top:1rem; padding:.8rem; background:#fff0e0; border-radius:10px; text-align:center; border:1px dashed #ffb366;">
                    <span style="font-size:.82rem; color:#cc4400; font-weight:700;">🚚 Domicilio GRATIS en tu primer pedido</span>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="features">
        <div class="features-inner">
            <div class="section-title">
                <h2>Todo en un solo lugar</h2>
                <p>Una plataforma diseñada para clientes, comercios y repartidores</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🛍️</div>
                    <h3>Explora comercios</h3>
                    <p>Descubre restaurantes y tiendas locales en Bucaramanga con catálogos completos y precios actualizados.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Pedidos rápidos</h3>
                    <p>Agrega productos al carrito, paga de forma segura y sigue el estado de tu pedido en tiempo real.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🗺️</div>
                    <h3>Seguimiento en mapa</h3>
                    <p>Visualiza la zona de cobertura y el estado de entrega directamente desde tu panel de pedidos.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🏪</div>
                    <h3>Gestiona tu comercio</h3>
                    <p>Si eres comerciante, administra tu catálogo, sube fotos de tus productos y controla los pedidos entrantes.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🛵</div>
                    <h3>Panel de repartidor</h3>
                    <p>Los repartidores pueden ver entregas disponibles, aceptarlas y gestionar su historial desde un panel dedicado.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔐</div>
                    <h3>Seguro y confiable</h3>
                    <p>Registro por roles (cliente, comercio, repartidor) con autenticación segura y control de acceso.</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>© {{ date('Y') }} <strong>PedidosYa</strong> · Bucaramanga, Colombia · Todos los derechos reservados.</p>
    </footer>

</body>
</html>
